<?php

class Error {
    /**
     * @param $message
     *
     * Shows error message
     */
    public static function set_error($message) {
      echo '<script>document.getElementById("error-handler").innerHTML = "<p>'.$message.'</p>";</script>';
    }
}