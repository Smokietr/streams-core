<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Application\ApplicationModel;

class ApplicationServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register and setup the application.
     */
    public function register()
    {
        $this->app->instance('streams.application', new Application(new ApplicationModel(), $this->app));

        app('config')->addNamespace('streams', __DIR__ . '/../../../../resources/config');

        if (file_exists(base_path('config/distribution.php'))) {

            app('streams.application')->locate();

            if (file_exists(base_path('config/database.php'))) {

                app('streams.application')->setup();
            }
        }
    }
}
