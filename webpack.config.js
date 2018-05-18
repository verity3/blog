var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./web/builds/')
    .setPublicPath('/builds')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .autoProvideVariables({
        "jQuery.tagsinput": "bootstrap-tagsinput"
    })
    .configureBabel(function(babelConfig) {
      
        babelConfig.presets.push('react');
    })
    .enableSassLoader()
    .enableReactPreset()
    .enableVersioning(false)
    .createSharedEntry('vendor', [
        'jquery',
    ]) 
    .addEntry('jquery', 'jquery/dist/jquery.js') 
    .addEntry('js/bootstrap', 'bootstrap/dist/js/bootstrap.js')
    .addStyleEntry('css/bootstrap', 'bootstrap/dist/css/bootstrap.min.css')   
    .addEntry('js/bootstrap-datepicker', 'bootstrap-datepicker/dist/js/bootstrap-datepicker.js')
    .addEntry('js/initial-setup', './src/NewsBundle/Resources/public/js/initial-setups.js')
    .addStyleEntry('css/bootstrap-datepicker', 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') 
    .addEntry('js/blogs', './src/NewsBundle/Resources/public/js/blogs.js') 
    .addStyleEntry('css/style', './src/NewsBundle/Resources/public/css/style.css') 
;

module.exports = Encore.getWebpackConfig();