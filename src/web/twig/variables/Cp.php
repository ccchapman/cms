<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\web\twig\variables;

use Craft;
use craft\base\UtilityInterface;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterCpSettingsEvent;
use craft\helpers\App;
use craft\helpers\ArrayHelper;
use craft\helpers\Cp as CpHelper;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Control panel functions
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0.0
 */
class Cp extends Component
{
    /**
     * @event RegisterCpNavItemsEvent The event that is triggered when registering control panel nav items.
     */
    const EVENT_REGISTER_CP_NAV_ITEMS = 'registerCpNavItems';

    /**
     * @event RegisterCpSettingsEvent The event that is triggered when registering control panel nav items.
     * @since 3.1.0
     */
    const EVENT_REGISTER_CP_SETTINGS = 'registerCpSettings';

    /**
     * Returns the Craft ID account URL.
     *
     * @return string
     */
    public function craftIdAccountUrl()
    {
        return Craft::$app->getPluginStore()->craftIdEndpoint . '/account';
    }

    /**
     * Returns the control panel nav items.
     *
     * Each control panel nav item should be defined by an array with the following keys:
     *
     * - `label` – The human-facing nav item label
     * - `url` – The URL the nav item should link to
     * - `id` – The HTML `id` attribute the nav item should have (optional)
     * - `icon` – The path to an SVG file that should be used as the nav item icon (optional)
     * - `fontIcon` – A character/ligature from Craft’s font icon set (optional)
     * - `badgeCount` – A number that should be displayed beside the nav item when unselected
     * - `subnav` – A sub-array of subnav items
     *
     * Subnav arrays should be associative, with identifiable keys set to sub-arrays with the following keys:
     *
     * - `label` – The human-facing subnav item label
     * - `url` – The URL the subnav item should link to
     *
     * For example:
     *
     * ```php
     * [
     *     'label' => 'Commerce',
     *     'url' => 'commerce',
     *     'subnav' => [
     *         'orders' => ['label' => 'Orders', 'url' => 'commerce/orders',
     *         'discounts' => ['label' => 'Discounts', 'url' => 'commerce/discounts',
     *     ],
     * ]
     * ```
     *
     * Control panel templates can specify which subnav item is selected by defining a `selectedSubnavItem` variable.
     *
     * ```twig
     * {% set selectedSubnavItem = 'orders' %}
     * ```
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function nav(): array
    {
        $craftPro = Craft::$app->getEdition() === Craft::Pro;
        $isAdmin = Craft::$app->getUser()->getIsAdmin();
        $generalConfig = Craft::$app->getConfig()->getGeneral();

        $navItems = [
            [
                'label' => Craft::t('app', 'Dashboard'),
                'url' => 'dashboard',
                'fontIcon' => 'gauge'
            ],
        ];

        if (Craft::$app->getSections()->getTotalEditableSections()) {
            $navItems[] = [
                'label' => Craft::t('app', 'Entries'),
                'url' => 'entries',
                'fontIcon' => 'section'
            ];
        }

        if (!empty(Craft::$app->getGlobals()->getEditableSets())) {
            $navItems[] = [
                'label' => Craft::t('app', 'Globals'),
                'url' => 'globals',
                'fontIcon' => 'globe'
            ];
        }

        if (Craft::$app->getCategories()->getEditableGroupIds()) {
            $navItems[] = [
                'label' => Craft::t('app', 'Categories'),
                'url' => 'categories',
                'fontIcon' => 'categories'
            ];
        }

        if (Craft::$app->getVolumes()->getTotalViewableVolumes()) {
            $navItems[] = [
                'label' => Craft::t('app', 'Assets'),
                'url' => 'assets',
                'fontIcon' => 'assets'
            ];
        }

        if ($craftPro && Craft::$app->getUser()->checkPermission('editUsers')) {
            $navItems[] = [
                'label' => Craft::t('app', 'Users'),
                'url' => 'users',
                'fontIcon' => 'users'
            ];
        }

        // Add any Plugin nav items
        $plugins = Craft::$app->getPlugins()->getAllPlugins();

        foreach ($plugins as $plugin) {
            if (
                $plugin->hasCpSection &&
                Craft::$app->getUser()->checkPermission('accessPlugin-' . $plugin->id) &&
                ($pluginNavItem = $plugin->getCpNavItem()) !== null
            ) {
                $navItems[] = $pluginNavItem;
            }
        }

        if ($isAdmin) {
            if ($craftPro && $generalConfig->enableGql) {
                $subNavItems = [
                    'explore' => [
                        'label' => Craft::t('app', 'Explore'),
                        'url' => 'graphql',
                    ],
                ];

                if ($generalConfig->allowAdminChanges) {
                    $subNavItems['schemas'] = [
                        'label' => Craft::t('app', 'Schemas'),
                        'url' => 'graphql/schemas',
                    ];
                }

                $subNavItems['tokens'] = [
                    'label' => Craft::t('app', 'Tokens'),
                    'url' => 'graphql/tokens',
                ];

                $navItems[] = [
                    'label' => Craft::t('app', 'GraphQL'),
                    'url' => 'graphql',
                    'icon' => '@app/icons/graphql.svg',
                    'subnav' => $subNavItems
                ];
            }
        }

        $utilities = Craft::$app->getUtilities()->getAuthorizedUtilityTypes();

        if (!empty($utilities)) {
            $badgeCount = 0;

            foreach ($utilities as $class) {
                /** @var UtilityInterface $class */
                $badgeCount += $class::badgeCount();
            }

            $navItems[] = [
                'url' => 'utilities',
                'label' => Craft::t('app', 'Utilities'),
                'fontIcon' => 'tool',
                'badgeCount' => $badgeCount
            ];
        }

        if ($isAdmin) {
            if ($generalConfig->allowAdminChanges) {
                $navItems[] = [
                    'url' => 'settings',
                    'label' => Craft::t('app', 'Settings'),
                    'fontIcon' => 'settings'
                ];
                $navItems[] = [
                    'url' => 'plugin-store',
                    'label' => Craft::t('app', 'Plugin Store'),
                    'fontIcon' => 'plugin'
                ];
            }
        }

        // Allow plugins to modify the nav
        $event = new RegisterCpNavItemsEvent([
            'navItems' => $navItems
        ]);
        $this->trigger(self::EVENT_REGISTER_CP_NAV_ITEMS, $event);
        $navItems = $event->navItems;

        // Figure out which item is selected, and normalize the items
        $path = Craft::$app->getRequest()->getPathInfo();

        if ($path === 'myaccount') {
            $path = 'users';
        }

        $foundSelectedItem = false;

        foreach ($navItems as &$item) {
            if (!$foundSelectedItem && ($item['url'] == $path || StringHelper::startsWith($path, $item['url'] . '/'))) {
                $item['sel'] = true;
                if (!isset($item['subnav'])) {
                    $item['subnav'] = false;
                }
                $foundSelectedItem = true;
            } else {
                $item['sel'] = false;
                $item['subnav'] = false;
            }

            if (!isset($item['id'])) {
                $item['id'] = 'nav-' . preg_replace('/[^\w\-_]/', '', $item['url']);
            }

            $item['url'] = UrlHelper::url($item['url']);

            if (!isset($item['badgeCount'])) {
                $item['badgeCount'] = 0;
            }
        }

        return $navItems;
    }

    /**
     * Returns the list of settings.
     *
     * @return array
     */
    public function settings(): array
    {
        $settings = [];

        $label = Craft::t('app', 'System');

        $settings[$label]['general'] = [
            'icon' => '@app/icons/sliders.svg',
            'label' => Craft::t('app', 'General')
        ];
        $settings[$label]['sites'] = [
            'icon' => '@app/icons/world.svg',
            'label' => Craft::t('app', 'Sites')
        ];

        if (!Craft::$app->getConfig()->getGeneral()->headlessMode) {
            $settings[$label]['routes'] = [
                'icon' => '@app/icons/routes.svg',
                'label' => Craft::t('app', 'Routes')
            ];
        }

        $settings[$label]['users'] = [
            'icon' => '@app/icons/users.svg',
            'label' => Craft::t('app', 'Users')
        ];
        $settings[$label]['email'] = [
            'icon' => '@app/icons/envelope.svg',
            'label' => Craft::t('app', 'Email')
        ];
        $settings[$label]['plugins'] = [
            'icon' => '@app/icons/plugin.svg',
            'label' => Craft::t('app', 'Plugins')
        ];

        $label = Craft::t('app', 'Content');

        $settings[$label]['fields'] = [
            'icon' => '@app/icons/field.svg',
            'label' => Craft::t('app', 'Fields')
        ];
        $settings[$label]['sections'] = [
            'icon' => '@app/icons/newspaper.svg',
            'label' => Craft::t('app', 'Sections')
        ];
        $settings[$label]['assets'] = [
            'icon' => '@app/icons/photo.svg',
            'label' => Craft::t('app', 'Assets')
        ];
        $settings[$label]['globals'] = [
            'icon' => '@app/icons/globe.svg',
            'label' => Craft::t('app', 'Globals')
        ];
        $settings[$label]['categories'] = [
            'icon' => '@app/icons/folder-open.svg',
            'label' => Craft::t('app', 'Categories')
        ];
        $settings[$label]['tags'] = [
            'icon' => '@app/icons/tags.svg',
            'label' => Craft::t('app', 'Tags')
        ];

        $label = Craft::t('app', 'Plugins');

        $pluginsService = Craft::$app->getPlugins();

        foreach ($pluginsService->getAllPlugins() as $plugin) {
            if ($plugin->hasCpSettings) {
                $settings[$label][$plugin->id] = [
                    'url' => 'settings/plugins/' . $plugin->id,
                    'icon' => $pluginsService->getPluginIconSvg($plugin->id),
                    'label' => $plugin->name
                ];
            }
        }

        // Allow plugins to modify the settings
        $event = new RegisterCpSettingsEvent([
            'settings' => $settings
        ]);
        $this->trigger(self::EVENT_REGISTER_CP_SETTINGS, $event);

        return $event->settings;
    }

    /**
     * Returns whether the control panel alerts are cached.
     *
     * @return bool
     */
    public function areAlertsCached(): bool
    {
        // The license key status gets cached on each Craftnet request
        return (Craft::$app->getCache()->get('licenseKeyStatus') !== false);
    }

    /**
     * Returns an array of alerts to display in the control panel.
     *
     * @return array
     */
    public function getAlerts(): array
    {
        return CpHelper::alerts(Craft::$app->getRequest()->getPathInfo());
    }

    /**
     * Returns the available environment variable and alias suggestions for
     * inputs that support them.
     *
     * @param bool $includeAliases Whether aliases should be included in the list
     * (only enable this if the setting defines a URL or file path)
     * @return string[]
     * @since 3.1.0
     */
    public function getEnvSuggestions(bool $includeAliases = false): array
    {
        $suggestions = [];
        $security = Craft::$app->getSecurity();

        $envSuggestions = [];
        foreach (array_keys($_SERVER) as $var) {
            if (is_string($var) && is_string($env = App::env($var))) {
                $envSuggestions[] = [
                    'name' => '$' . $var,
                    'hint' => $security->redactIfSensitive($var, Craft::getAlias($env, false))
                ];
            }
        }
        ArrayHelper::multisort($envSuggestions, 'name');
        $suggestions[] = [
            'label' => Craft::t('app', 'Environment Variables'),
            'data' => $envSuggestions,
        ];

        if ($includeAliases) {
            $aliasSuggestions = [];
            foreach (Craft::$aliases as $alias => $path) {
                if (is_array($path)) {
                    if (isset($path[$alias])) {
                        $aliasSuggestions[] = [
                            'name' => $alias,
                            'hint' => $path[$alias],
                        ];
                    }
                } else {
                    $aliasSuggestions[] = [
                        'name' => $alias,
                        'hint' => $path,
                    ];
                }
            }
            ArrayHelper::multisort($aliasSuggestions, 'name');
            $suggestions[] = [
                'label' => Craft::t('app', 'Aliases'),
                'data' => $aliasSuggestions,
            ];
        }

        return $suggestions;
    }

    /**
     * Returns ASCII character mappings for the given language, if it differs from the application language.
     *
     * @param string $language
     * @return array|null
     * @since 3.1.9
     */
    public function getAsciiCharMap(string $language)
    {
        if ($language === Craft::$app->language) {
            return null;
        }

        return StringHelper::asciiCharMap(true, $language);
    }

    /**
     * Returns the available template path suggestions for template inputs.
     *
     * @return string[]
     * @since 3.1.0
     */
    public function getTemplateSuggestions(): array
    {
        // Get all the template files sorted by path length
        $root = Craft::$app->getPath()->getSiteTemplatesPath();

        if (!is_dir($root)) {
            return [];
        }

        $directory = new \RecursiveDirectoryIterator($root);

        $filter = new \RecursiveCallbackFilterIterator($directory, function($current) {
            // Skip hidden files and directories, as well as node_modules/ folders
            if ($current->getFilename()[0] === '.' || $current->getFilename() === 'node_modules') {
                return false;
            }
            return true;
        });

        $iterator = new \RecursiveIteratorIterator($filter);
        /** @var \SplFileInfo[] $files */
        $files = [];
        $pathLengths = [];

        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            if (!$file->isDir() && $file->getFilename()[0] !== '.') {
                $files[] = $file;
                $pathLengths[] = strlen($file->getRealPath());
            }
        }

        array_multisort($pathLengths, SORT_NUMERIC, $files);

        // Now build the suggestions array
        $suggestions = [];
        $templates = [];
        $sites = [];
        $config = Craft::$app->getConfig()->getGeneral();
        $rootLength = strlen($root);

        foreach (Craft::$app->getSites()->getAllSites() as $site) {
            $sites[$site->handle] = Craft::t('site', $site->name);
        }

        foreach ($files as $file) {
            $template = substr($file->getRealPath(), $rootLength + 1);

            // Can we chop off the extension?
            $extension = $file->getExtension();
            if (in_array($extension, $config->defaultTemplateExtensions, true)) {
                $template = substr($template, 0, strlen($template) - (strlen($extension) + 1));
            }

            $hint = null;

            // Is it in a site template directory?
            foreach ($sites as $handle => $name) {
                if (strpos($template, $handle . DIRECTORY_SEPARATOR) === 0) {
                    $hint = $name;
                    $template = substr($template, strlen($handle) + 1);
                    break;
                }
            }

            // Avoid listing the same template path twice (considering localized templates)
            if (isset($templates[$template])) {
                continue;
            }

            $templates[$template] = true;
            $suggestions[] = [
                'name' => $template,
                'hint' => $hint,
            ];
        }

        ArrayHelper::multisort($suggestions, 'name');

        return [
            [
                'label' => Craft::t('app', 'Templates'),
                'data' => $suggestions,
            ]
        ];
    }
}
