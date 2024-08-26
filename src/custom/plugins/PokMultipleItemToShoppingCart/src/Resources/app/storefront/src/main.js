// Import all necessary Storefront plugins
import ExamplePlugin from './example-plugin/example-plugin.plugin';
import DynamicFormSearch from './ajax/dynamic-form-search'

console.log('SwagBasicExampleTheme JS loaded');

// Register your plugin via the existing PluginManager
const PluginManager = window.PluginManager;

PluginManager.register('ExamplePlugin', ExamplePlugin, '[data-example-plugin]');
//PluginManager.register('DynamicFormSearch', DynamicFormSearch);

