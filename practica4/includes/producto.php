<?php
    class Producto {
        public $id;
        public $nombre;
        public $precio;
        public $extension;

        public function __construct($id, $nombre, $precio, $extension) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->precio = $precio;
            $this->extension = $extension;
        }
    }