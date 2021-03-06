<?php

namespace Tests;

use App\Events;
use App\Services\Plugin;

class NotifyFailedPluginTest extends TestCase
{
    public function testHandle()
    {
        $content = [];
        $plugin = new Plugin('', ['title' => 'ff']);

        event(new Events\PluginBootFailed($plugin));
        event(new Events\RenderingFooter($content));
        $this->assertCount(0, $content);

        $this->actAs('normal');
        event(new Events\PluginBootFailed($plugin));
        event(new Events\RenderingFooter($content));
        $this->assertCount(0, $content);

        $this->actAs('admin');
        event(new Events\PluginBootFailed($plugin));
        event(new Events\RenderingFooter($content));
        $this->assertStringContainsString('blessing.ui.message', $content[0]);
    }
}
