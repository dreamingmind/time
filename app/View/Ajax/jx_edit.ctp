<?php
$result = array(
    'flash' => $this->Session->flash(),
    'valid' => $response['valid'],
    'result' => $response['result']
);
echo json_encode($result);