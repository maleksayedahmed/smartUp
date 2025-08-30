<?php

namespace App\Traits;

trait HasTranslationFields
{
    /**
     * Boot the trait
     */
    protected static function bootHasTranslationFields()
    {
        static::creating(function ($model) {
            $model->handleTranslationFields();
        });

        static::updating(function ($model) {
            $model->handleTranslationFields();
        });
    }

    /**
     * Handle translation fields before saving
     */
    protected function handleTranslationFields()
    {
        $translationFields = $this->getTranslationFields();

        foreach ($translationFields as $field) {
            $arField = $field . '_ar';
            $enField = $field . '_en';

            // Check if both AR and EN fields exist in the request
            if (isset($this->attributes[$arField]) || isset($this->attributes[$enField])) {
                $translations = [];

                // Add Arabic translation if exists
                if (isset($this->attributes[$arField]) && !empty($this->attributes[$arField])) {
                    $translations['ar'] = $this->attributes[$arField];
                }

                // Add English translation if exists
                if (isset($this->attributes[$enField]) && !empty($this->attributes[$enField])) {
                    $translations['en'] = $this->attributes[$enField];
                }

                // Store as JSON in the main field
                if (!empty($translations)) {
                    $this->attributes[$field] = json_encode($translations);
                }

                // Remove the individual language fields from attributes
                unset($this->attributes[$arField]);
                unset($this->attributes[$enField]);
            }
        }
    }

    /**
     * Get the translation fields for this model
     * Override this method in your model to specify which fields should be handled
     */
    protected function getTranslationFields(): array
    {
        return $this->translationFields ?? ['title', 'description'];
    }
}
