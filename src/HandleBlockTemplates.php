<?php

namespace PBoivin\TwillFormTemplates;

trait HandleBlockTemplates
{
    public function afterSaveHandleBlockTemplates($object, $fields)
    {
        if ($object->wasRecentlyCreated) {
            $object->prefillBlockSelection();
        }
    }
}
