<?php

use Spatie\ImageOptimizer\OptimizerChain;
use Psr\Log\LoggerInterface;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Svgo;

/**
 * Class RedFinchOptim_Image
 *
 * @author James Wigger <james@rootstudio.co.uk>
 */
class RedFinchOptim_Image
{
    private static $table = 'redfinch_optim_tasks';

    /**
     * Event handler for image creation events
     *
     * @param PerchSystemEvent $event
     */
    public static function onCreateImage(PerchSystemEvent $event)
    {
        /**
         * @var PerchAssets_Asset $asset
         */
        $asset = $event->subject;

        $data = [
            'taskFile'    => $asset->file_name,
            'taskPath'    => $asset->file_path,
            'taskPreSize' => filesize($asset->file_path)
        ];

        $API = new PerchAPI(1.0, 'redfinch_optim');
        $DB = $API->get('DB');

        $DB->insert(PERCH_DB_PREFIX . self::$table, $data);
    }

    /**
     * Handle the task execution using the optimisation toolkit
     *
     * @param string          $path
     * @param LoggerInterface $logger
     */
    public static function onTaskExecute($path, LoggerInterface $logger)
    {
        $API = new PerchAPI(1.0, 'redfinch_optim');

        $PerchSettings = $API->get('Settings');
        $OptimSettings = RedFinchOptim_Settings::fetch();

        $OptimiserChain = new OptimizerChain();

        // GIFs
        if ((bool) $OptimSettings->get('gifsicle_enabled', 1)->value()) {
            $args = ['-b'];
            $args[] = '-O' . $OptimSettings->get('gifsicle_level', 3)->value();

            $OptimiserChain->addOptimizer(new Gifsicle($args));
        }

        // JPEGs
        if ((bool) $OptimSettings->get('jpegoptim_enabled', 1)->value()) {
            $args = [];

            if ((bool) $OptimSettings->get('jpegoptim_progressive', 1)->value()) {
                $args[] = '--all-progressive';
            }

            if ((bool) $OptimSettings->get('jpegoptim_strip', 1)->value()) {
                $args[] = '--strip-all';
            }

            $args[] = '--max ' . $OptimSettings->get('jpegoptim_quality', 80)->value();

            $OptimiserChain->addOptimizer(new Jpegoptim($args));
        }

        // PNGs (lossy must come first)
        if ((bool) $OptimSettings->get('pngquant_enabled', 1)->value()) {
            $args = ['--force'];
            $args[] = '--quality ' . $OptimSettings->get('pngquant_quality', '90-100')->value();
            $args[] = '--speed ' . $OptimSettings->get('pngquant_speed', 3)->value();

            $OptimiserChain->addOptimizer(new Pngquant($args));
        }

        // PNGs
        if ((bool) $OptimSettings->get('optipng_enabled', 1)->value()) {
            $args = ['-i0', '-quiet'];
            $args[] = '-o ' . $OptimSettings->get('optipng_level', 2)->value();

            // Appears to be failing - review later.
            /* if ((bool) $OptimSettings->get('optipng_strip', 1)->value()) {
                $args[] = '−strip all';
            } */

            $OptimiserChain->addOptimizer(new Optipng($args));
        }

        // SVGs
        if ((bool) $OptimSettings->get('svgo_enabled', 1)->value()) {
            $args = [];

            foreach (json_decode($OptimSettings->get('svgo_plugins', '[]')->value()) as $plugin) {
                $args[] = '--enable=' . $plugin;
            }

            $OptimiserChain->addOptimizer(new Svgo($args));
        }

        // Timeout
        if(is_numeric($PerchSettings->get('redfinch_optim_timeout')->val())) {
            $OptimiserChain->setTimeout($PerchSettings->get('redfinch_optim_timeout')->val());
        }

        // Handle timeouts
        try {
            $OptimiserChain->useLogger($logger)->optimize($path);
        } catch(Exception $ex) {
            $logger->error($ex->getMessage());
        }
    }
}
