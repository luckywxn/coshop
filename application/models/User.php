<?php
/**
 * 用户管理
 * @author  wuxianneng
 * @date    2016-11-17 15:25:26
 */
class UserModel
{
    /**
     * 数据库类实例
     * @var object
     */
    public $dbh = null;

    public $mch = null;

    /**
     * Constructor
     */
    public function __construct($dbh, $mch = null)
    {
        $this->dbh = $dbh;
        $this->mch = $mch;
    }

    /**
     * 用户登陆校验
     * @author Alan
     * @time 2016-11-15 13:48:17
     **/
    public function UserLogin($params)
    {
        $sql = "select um.*,ums.login_password,umm.merchant_no from user_member um 
                left join user_member_security ums on ums.member_no = um.member_no 
                left join user_merchant umm on umm.member_no = um.member_no 
                where um.member_type = 1 AND um.`member_status` = 2 AND um.ok_del = 0 AND um.user_name = '{$params['username']}'";
        $row = $this->dbh->select_row($sql);
        if(is_array($row) && count($row) > 0){
            $hash = $row['login_password'];
            if (password_verify($params['userpwd'], $hash)) {
                return $row;
            }else {
                return false;
            }
        }else
            return false;
    }

    /**检测用户是否存在
     * @param $username
     * @return mixed
     */
    public function checkUserIsExist($username)
    {
        $sql =  "SELECT * FROM user_member WHERE  ok_del = 0 AND `user_name` = '$username'";
        return $this->dbh->select_row($sql);
    }

    /**
     * 添加用户
     * @author wuxianneng
     * @time 2016-11-14 15:21:32
     */
    public function addUser($data,$security)
    {
        $this->dbh->begin();
        try{
            $res = $this->dbh->insert('user_member', $data);
            if (!$res) {
                $this->dbh->rollback();
                return false;
            }
            $id = $res;
            $res = $this->dbh->insert('user_member_security', $security);
            if (!$res) {
                $this->dbh->rollback();
                return false;
            }

            $this->dbh->commit();
            return $id;
        } catch (Exception $e) {
            $this->dbh->rollback();
            return false;
        }
    }

    public function updateUser($id = 0, $data = array())
    {
        $this->dbh->begin();
        try {
            $res = $this->dbh->update('user_member', $data, 'sysno=' . intval($id));
            if (!$res) {
                $this->dbh->rollback();
                return false;
            }

            $this->dbh->commit();
            return true;

        } catch (Exception $e) {
            $this->dbh->rollback();
            return false;
        }
    }

    public function updateUserPassword($id = 0, $data = array())
    {
        $this->dbh->begin();
        try {
            //concap_role update
            $res = $this->dbh->update('user_member', $data, 'sysno=' . intval($id));

            if (!$res) {
                $this->dbh->rollback();
                return false;
            }

            $this->dbh->commit();
            return true;

        } catch (Exception $e) {
            $this->dbh->rollback();
            return false;
        }
    }

    /**
     * 删除用户
    **/
    public function delUser($id)
    {
        $params['ok_del'] = 1;
        return $this->dbh->update('user_member',$params,'sysno=' . intval($id));
    }

    /**
     * 用户状态置为停用
    **/
    public function changeUserStatus($id,$lockstatus)
    {
        return $this->dbh->update('user_member',$lockstatus,'sysno=' . intval($id));
    }


}