<?php
/**
 * Created by PhpStorm.
 * User: SFW
 * Date: 06/05/2019
 * Time: 11:01
 */

class AlertManager
{
    /**
     * Correspond to the database
     * @var
     */
    private static $bdd;

    /**
     * Set the database.
     */
    private static function setBdd(){
        global $wpdb;
        self::$bdd = new PDO('mysql:host='.$wpdb->dbhost.'; dbname='.$wpdb->dbname, $wpdb->dbuser, $wpdb->dbpassword);
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } //setBdd()

    /**
     * Return the database.
     * @return mixed
     */
    protected function getBdd(){
        if (self:: $bdd == null)
            self::setBdd();
        return self::$bdd;
    } //getBdd()


    /**
     * Add an alert in the database with today date and current user.
     * @param $content
     * @param $endDate
     */
    public function addAlertDB($content, $endDate, $codes){
        global $wpdb;

        $current_user = wp_get_current_user();

        if (isset($current_user)) {
            $user = $current_user->user_login;
        }

        $creationDate = date('Y-m-d');

        $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO `alerts`(`ID_alert`,`author`, `text`, `creation_date`, `end_date`, `codes` )
                        VALUES (%d, %s, %s, %s, %s, %s)",
                null,
                $user,
                $content,
                $creationDate,
                $endDate,
                $codes
            )
        );
    } //addAlertDB()

    /**
     * Delete the alert in database.
     * @param $id
     */
    public function deleteAlertDB($id)
    {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM `alerts` WHERE ID_alert = %d",
                $id
            )
        );
    } //deleteAlertDB()

    /**
     * Return the list of alerts.
     * @return array|null|object
     */
    public function getListAlert()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM alerts", ARRAY_A);
        return $result;
    } //getListAlert()


    /**
     * Return the alert corresponding to an ID
     * @param $id
     * @return array|null|object|void
     */
    public function getAlertByID($id) {
        global $wpdb;
        $result = $wpdb->get_row('SELECT * FROM alerts WHERE ID_alert ="'.$id.'"',ARRAY_A );
        return $result;
    } //getAlertByID()

    /**
     * Return the list of information created by an user
     * @param $user
     * @return array|null|object
     */
    public function getListAlertByAuthor($user)
    {
        global $wpdb;
        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM alerts WHERE author = %s",
                $user
            ), ARRAY_A
        );
        return $result;
    } //getListAlertByAuthor()

    /**
     * Modify the alert in the database.
     * @param $id
     * @param $content
     * @param $endDate
     */
    public function modifyAlert($id, $content, $endDate){
        $req = $this->getBdd()->prepare('UPDATE alerts SET text=:content, end_date=:endDate
                                         WHERE ID_alert=:id');
        $req->bindParam(':id',$id);
        $req->bindParam(':content',$content);
        $req->bindParam(':endDate',$endDate);

        $req->execute();
    } //modifyAlert()



}