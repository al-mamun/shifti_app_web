<?php

namespace App\Observers;

use App\Models\Banner;
use Exception;

class BannerObserver
{
    /**
     * Handle the Banner "created" event.
     *
     * @param  Banner  $banner
     * @return void
     * @throws Exception
     */
    public function created(Banner $banner)
    {
        $this->clearCache();
    }

    /**
     * Handle the Banner "updated" event.
     *
     * @param  Banner  $banner
     * @return void
     * @throws Exception
     */
    public function updated(Banner $banner)
    {
        $this->clearCache();
    }

    /**
     * Handle the Banner "deleted" event.
     *
     * @param  Banner  $banner
     * @return void
     * @throws Exception
     */
    public function deleted(Banner $banner)
    {
        $this->clearCache();
    }

    /**
     * Handle the Banner "restored" event.
     *
     * @param  Banner  $banner
     * @return void
     * @throws Exception
     */
    public function restored(Banner $banner)
    {
        $this->clearCache();
    }

    /**
     * Handle the Banner "force deleted" event.
     *
     * @param  Banner  $banner
     * @return void
     * @throws Exception
     */
    public function forceDeleted(Banner $banner)
    {
        $this->clearCache();
    }

    /**
     * @throws Exception
     */
    protected function clearCache()
    {
        cache()->forget('banner');
    }
}
