<?php

namespace Tonysm\StimulusLaravel;

use Illuminate\Support\Arr;

class StimulusLaravel
{
    public function controller($controllers)
    {
        $controllers = collect(Arr::wrap($controllers));

        return $controllers->map(function ($configs, $controller) {
            if (is_numeric($controller)) {
                $controller = $configs;
                $configs = [];
            }

            return [
                'controller' => $controller,
                'target' => $configs['target'] ?? null,
                'value' => $configs['value'] ?? null,
                'class' => $configs['class'] ?? null,
            ];
        })->reduce(function ($acc, $configs) {
            $acc['data-controller'] = array_merge($acc['data-controller'] ?? [], [$configs['controller']]);

            foreach (['target', 'value', 'class'] as $attribute) {
                if ($configs[$attribute]) {
                    foreach ($configs[$attribute] as $key => $val) {
                        $acc['data-'.$configs['controller'].'-'.$key.'-'.$attribute] = $val;
                    }
                }
            }

            return $acc;
        }, collect())->map(function ($value, $attr) {
            $attr = e($attr);
            $controllers = e(is_array($value) ? implode(' ', $value) : $value);

            return "{$attr}=\"{$controllers}\"";
        })->join(' ');
    }

    public function target($targets)
    {
        $targets = collect(Arr::wrap($targets));

        return $targets->reduce(function ($acc, $targetName, $controller) {
            $acc['data-'.$controller.'-target'] = $targetName;

            return $acc;
        }, collect())->map(function ($value, $attr) {
            $attr = e($attr);
            $value = e($value);

            return "{$attr}=\"{$value}\"";
        })->join(' ');
    }
}
