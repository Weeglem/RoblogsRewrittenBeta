<?php

class WebsiteLinks{

    static function Create_Link($key,$value)
    {
        $info = parse_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $query2 = isset($info['query']) == true ? $info['query'] : "";
        parse_str( $query2, $query );
        if(isset($query["page"])){
            unset($query["page"]);
        }
        return $info['scheme'].'://'.$info['host'].$info['path'].'?'. http_build_query( 
        $query ? 
        array_merge( $query, array($key => $value ) ) : 
        array( $key => $value ) ); 
    }

    /** /Roblogs_Server/Data/Models/ */
    static function Server_ModelsFolder(){return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Models/";}

    /** /Roblogs_Server/Data/Games/ */
    static function Server_GamesFolder(){return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Games/";}

    /** /Roblogs_Server/Data/Decals/ */
    static function Server_DecalsFolder(){return "$_SERVER[DOCUMENT_ROOT]/Roblogs_Server/Data/Decals/";}


    /** /Website/thumbnails/decals/ */
    static function ServerThumbs_Decals(){return "$_SERVER[DOCUMENT_ROOT]/Website/thumbnails/decals/";}


    /** /Website/thumbnails/games/ */
    static function ServerThumbs_Games(){return "$_SERVER[DOCUMENT_ROOT]/Website/thumbnails/games/";}

    /** /Website/thumbnails/models/ */
    static function ServerThumbs_Models(){return "$_SERVER[DOCUMENT_ROOT]/Website/thumbnails/models/";}







    static function Home_Page()
    {
        return "http://$_SERVER[SERVER_NAME]/Home.php";
    }

    static function LogOut_API(){
        return "http://$_SERVER[SERVER_NAME]/Account/logout.php";
    }

    static function Profile_Page($ID)
    {
        return "http://$_SERVER[SERVER_NAME]/User/Profile.php?id=".rawurlencode($ID);
    }

    static function Game_Page($ID)
    {
        return "http://$_SERVER[SERVER_NAME]/Asset/?id=".rawurlencode($ID)."&Type=Game";
    }

    static function Asset_Page($ID,$Type = "Model")
    {
        return "http://$_SERVER[SERVER_NAME]/Asset/?id=".rawurlencode($ID)."&Type=".$Type;
    }

    static function Missing_Thumbnail_ServerFile()
    {
        return "$_SERVER[DOCUMENT_ROOT]/IMG/QuestionMark.png";
    }

    static function MyUploads_Page()
    {
        return "http://$_SERVER[SERVER_NAME]/Uploads";
    }
}

?>