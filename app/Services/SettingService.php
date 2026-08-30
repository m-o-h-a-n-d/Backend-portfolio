<?php

namespace App\Services;

use App\Repository\SettingRepository;
use App\Utils\ImageManager;

class SettingService
{
    public function __construct(
        protected SettingRepository $settingRepository,
        protected ImageManager $imageManager
    ) {}

    public function getSettings()
    {
        return $this->settingRepository->getSettings();
    }

    public function getSetting($id)
    {
        return $this->settingRepository->getSetting($id) ?? false;
    }

    public function getFirstSetting()
    {
        return $this->settingRepository->getFirstSetting() ?? false;
    }

    public function store($data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->imageManager->uploadSingleImage($data['logo'], 'settings', 's3');
            if (! $data['logo']) {
                return false;
            }
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = $this->imageManager->uploadSingleImage($data['favicon'], 'settings', 's3');
            if (! $data['favicon']) {
                return false;
            }
        }

        if (isset($data['cv'])) {
            $data['cv'] = $this->imageManager->uploadSingleImage($data['cv'], 'settings', 's3', null, true);
            if (! $data['cv']) {
                return false;
            }
        }

        return $this->settingRepository->store($data);
    }

    public function update($data)
    {
        $setting = $this->settingRepository->getFirstSetting();
        if (! $setting) {
            return false;
        }

        if (isset($data['logo'])) {
            $data['logo'] = $this->imageManager->uploadSingleImage(
                $data['logo'],
                'settings',
                's3',
                $setting->logo
            );
            if (! $data['logo']) {
                return false;
            }
        }

        if (isset($data['favicon'])) {
            $data['favicon'] = $this->imageManager->uploadSingleImage(
                $data['favicon'],
                'settings',
                's3',
                $setting->favicon
            );
            if (! $data['favicon']) {
                return false;
            }
        }

        if (isset($data['cv'])) {
            $data['cv'] = $this->imageManager->uploadSingleImage(
                $data['cv'],
                'settings',
                's3',
                $setting->cv,
                true
            );
            if (! $data['cv']) {
                return false;
            }
        }

        return $this->settingRepository->update($setting, $data);
    }

    public function delete($id)
    {
        $setting = $this->settingRepository->getSetting($id);
        if (! $setting) {
            return false;
        }
        $this->imageManager->deleteImageFromLocal($setting->logo, 's3');
        $this->imageManager->deleteImageFromLocal($setting->favicon, 's3');
        $this->imageManager->deleteImageFromLocal($setting->cv, 's3');
        return $this->settingRepository->delete($setting);
    }
}
