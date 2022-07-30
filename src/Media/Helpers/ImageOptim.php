<?php namespace Escape\Argon\Media\Helpers;

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;

/**
 * Class ImageOptim
 * @package Escape\Argon\Media\Helpers
 *
 * For documentation of ImageOptimizer see the link below
 * https://github.com/psliwa/image-optimizer
 *
 */
class ImageOptim
{
    protected $enable;

    // public $factory;

    public $optimizer;

    public function __construct()
    {
        $this->enabled = (bool) config('argon.medialibrary.optimize.enable', false);

        if($this->isEnabled())
        {
            $this->optimizer = OptimizerChainFactory::create()
                ->addOptimizer(new Jpegoptim([
                    '--strip-all',
                    '--all-progressive',
                    '-m70',
                ]))
                ->addOptimizer(new Optipng([
                    '-i0', 
                    '-o2', 
                    '-strip all', 
                    '-quiet',
                ]))
                ->addOptimizer(new Gifsicle([
                    '-b',
                    '-05',
                ]));
        }
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function optimize($filepath)
    {
        if (!$this->isEnabled())
        {
            return false;
        }

        if (!file_exists($filepath))
        {
            return false;
        }

        $optimizer = $this->optimizer;
        $optimizer->optimize($filepath);

        return true;
    }
}