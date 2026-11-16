<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

abstract class BaseReportPage extends Page
{
    protected string $view = 'filament.pages.reports.report-page';

    abstract public function getReportData(): array;

    protected function getViewData(): array
    {
        return [
            'reportData' => $this->getReportData(),
        ];
    }
}
