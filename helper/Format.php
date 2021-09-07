<?php

class Format
{
    public function formatDate($date){
        return date('F j, Y, g:i a', strtotime($date));
    }

    public function textShorten($text, $limit = 400){
        $text = $text. " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        return $text;

    }

    public function validation($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

     public function title(){
         $path = $_SERVER['SCRIPT_FILENAME'];
         $title = basename($path, '.php');
         //$title = str_replace('_', ' ', $title);
         if ($title == 'index') {
             $title = 'home';
         }elseif ($title == 'contact') {
             $title = 'contact';
         }
         return $title = ucfirst($title);
     }

    public function roundAmount($item_price){
        
        $mod =  $item_price % 100;
        if($mod > 0 && $mod < 50){
            $item_price =  $item_price + 50-$mod;
            $item_price =  floor($item_price);
        }else if($mod > 50){
            $item_price =  $item_price + 100-$mod;
            $item_price =  floor($item_price);
        }
        return $item_price;

    }
}