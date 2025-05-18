<?php
function removeEmptyOptionalFields(array $optionalFields, array &$inputs): array
{
    foreach ($optionalFields as $field) {
        if (!array_key_exists($field, $inputs)) {
            continue;
        }

        if (is_null($inputs[$field]) || $inputs[$field] === '') {
            unset($inputs[$field]);
        }
    }
    return $inputs;
}
