<?php

namespace Pboivin\TwillFormTemplates;

trait HandleFormTemplates
{
    public function afterSaveHandleFormTemplates($object, $fields)
    {
        if ($object->wasRecentlyCreated) {
            $object->prefillBlockSelection();
        }
    }
}
