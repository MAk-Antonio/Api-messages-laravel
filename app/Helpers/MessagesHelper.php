<?php
class MessagesHelper
{
    public function prepareData($data)
    {
        unset($data['subject']);
        unset($data['destination']);
        return $data;
    }
}
