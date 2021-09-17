<?php

namespace WConfig\Libraries;

class WConfig {

    protected $mdlWConfig;

    public function __construct()
    {
        $this->mdlWConfig = new \WConfig\Models\WConfig();
    }

    public function getConfig($code, $onlyValue = TRUE)
    {
        $config = $this->mdlWConfig->asObject()->where('code',$code)->first();
        if ($onlyValue ===TRUE) {
            if (env('app.multiLanguage')) {
                $value = (array) json_decode($config->value);
                return $value[WLANG];
            } else {
                return $config->value;
            }
        } else {
            return $config;
        }
    }

    public function setConfig($code, $value, $lang = NULL)
    {
        $config = $this->mdlWConfig->asObject()->where('code',$code)->first();
        if (env('app.multiLanguage')) {
            $values = (array) json_decode($config->value);
            if ($lang === NULL) {
                $values[WLANG] = $value;
            } else {
                $values[$lang] = $value;
            }
            $this->mdlWConfig->update($config->id, ['value' => json_encode($values)]);
        } else {
            $this->mdlWConfig->update($config->id, ['value' => $value]);
        }
    }

    public function newConfig($name, $code, $value, $lang = NULL, $inputType = 'text', $inputValues = NULL, $group = NULL)
    {
        $insertData = ['name' => $name, 'code' => $code, 'input_type' => $inputType, 'input_values' => $inputValues, 'group' => $group];
        if (env('app.multiLanguage')) {
            if ($lang === NULL) {
                $insertData['value'] = json_encode([WLANG => $value]);
            } else {
                $insertData['value'] = json_encode([$lang => $value]);
            }
        } else {
            $insertData['value'] = $value;
        }
        $mdlWConfig = new \WConfig\Models\WConfig();
        $mdlWConfig->insert($insertData);
        return TRUE;
    }

    public function getAll($group = NULL)
    {
        if ($group === NULL)
            return $this->mdlWConfig->findAll();
        else
            return $this->mdlWConfig->where('group',$group)->findAll();
    }

    public function updateConfig($code, $data)
    {
        $config = $this->mdlWConfig->asObject()->where('code',$code)->first();
        return $this->mdlWConfig->update($config->id, $data);
    }

}
