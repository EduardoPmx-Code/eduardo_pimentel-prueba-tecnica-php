<?php

namespace Controllers;

class StatusServerController
{
    /**
     * Maneja la solicitud para obtener el estado del servidor.
     *
     * @return void
     */
    public function checkStatus(): void
    {
        echo json_encode([
            'status' => 'success',
            'message' => 'Server is alive'
        ]);
    }
}
