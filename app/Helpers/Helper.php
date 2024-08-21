<?php
use App\Models\WorkType;
function getWorkTypesForDropdown()
    {
        return WorkType::where('is_delete', 0)->pluck('name', 'id')->toArray();
    }
?>