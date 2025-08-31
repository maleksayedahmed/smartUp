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

            $hasAr = array_key_exists($arField, $this->attributes);
            $hasEn = array_key_exists($enField, $this->attributes);
            $hasJson = array_key_exists($field, $this->attributes);

            $jsonTranslations = [];

            // Normalize existing JSON value (if provided)
            if ($hasJson) {
                $raw = $this->attributes[$field];
                if (is_array($raw)) {
                    $jsonTranslations = $raw;
                } elseif (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $jsonTranslations = $decoded;
                    }
                }
            }

            // Merge AR/EN scalar fields into JSON
            if ($hasAr && !empty($this->attributes[$arField])) {
                $jsonTranslations['ar'] = $this->attributes[$arField];
            }
            if ($hasEn && !empty($this->attributes[$enField])) {
                $jsonTranslations['en'] = $this->attributes[$enField];
            }

            // If JSON exists but *_ar/_en missing, backfill scalar columns to keep both in sync
            if (!empty($jsonTranslations)) {
                $arValue = $jsonTranslations['ar'] ?? ($jsonTranslations['en'] ?? null);
                $enValue = $jsonTranslations['en'] ?? ($jsonTranslations['ar'] ?? null);

                if (!$hasAr || (isset($this->attributes[$arField]) && $this->attributes[$arField] === null)) {
                    $this->attributes[$arField] = $arValue ?? '';
                }
                if (!$hasEn || (isset($this->attributes[$enField]) && $this->attributes[$enField] === null)) {
                    $this->attributes[$enField] = $enValue ?? '';
                }

                // Persist JSON using Spatie if available; otherwise, assign normalized array
                if (method_exists($this, 'setTranslations')) {
                    $this->setTranslations($field, $jsonTranslations);
                } else {
                    $this->attributes[$field] = json_encode($jsonTranslations, JSON_UNESCAPED_UNICODE);
                }
            }

            // IMPORTANT: Do NOT unset *_ar/_en to support legacy/non-nullable columns
        }
    }

    /**
     * Get the translation fields for this model
     * Override this method in your model to specify which fields should be handled
     */
    protected function getTranslationFields(): array
    {
        // Prefer the model's translatable fields (from spatie/laravel-translatable)
        if (property_exists($this, 'translatable') && is_array($this->translatable) && !empty($this->translatable)) {
            return $this->translatable;
        }
        // Fallback to explicitly defined list on the model, or sensible defaults
        if (property_exists($this, 'translationFields') && is_array($this->translationFields) && !empty($this->translationFields)) {
            return $this->translationFields;
        }
        return ['title', 'description'];
    }
}
