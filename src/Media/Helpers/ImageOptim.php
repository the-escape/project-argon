<?php namespace Escape\Argon\Media\Helpers;

use ImageOptimizer\OptimizerFactory;

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

    public $factory;

    public function __construct()
    {
        $this->enabled = (bool) config('argon.medialibrary.optimize.enable', false);

        if($this->isEnabled())
        {
            $this->factory = new OptimizerFactory([
                'ignore_errors' => false,
                'execute_only_first_jpeg_optimizer' => false,
                'execute_only_first_png_optimizer' => false,
                'jpegoptim_options' => ['--strip-all', '--all-progressive', '-m70'],
                'optipng_options' => ['-i0', '-o2', '-strip all', '-quiet'],
                'gifsicle_options' => ['-b', '-O5'],
            ]);
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

        $optimizer = $this->factory->get();
        $optimizer->optimize($filepath);

        return true;
    }
}