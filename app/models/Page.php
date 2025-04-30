<?php
class Page
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }




    public function get_all_products() 
    {
        $this->db->query('SELECT * FROM products');
        $result = $this->db->resultSet();
        return $result;
    }
    public function delete_product($id)
    {
        $this->db->query("DELETE FROM products WHERE id = :id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_cat_products($id) {
        $this->db->query('SELECT * FROM products WHERE p_cat = :id');
         $this->db->bind(':id', $id);
        $result = $this->db->resultSet();
        return $result;
    }


    public function get_single_order($id) {
        $this->db->query('SELECT * FROM product_order_list WHERE p_id = :id');
         $this->db->bind(':id', $id);
        $result = $this->db->resultSet();
        return $result;
    }


      public function get_single_products($id) {
        $this->db->query('SELECT * FROM products WHERE id = :id');
         $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }
    
    public function email_verify($email) 
    {
        $this->db->query('SELECT * FROM auth WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if($row)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    public function email_verify_phone($phone) 
    {
        $this->db->query('SELECT * FROM auth WHERE phone = :phone');

        $this->db->bind(':phone', $phone);

        $row = $this->db->single();
        
        if($row)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }


    public function vendor_email_verify($email) 
    {
        $this->db->query('SELECT * FROM vendors WHERE vendor_email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if($row)
        {
            return $row;
        }
        else
        {
            return false;
        }
    }

    public function check_pass($opass)
    {
        $this->db->query('SELECT * from auth where id = :id');
        $this->db->bind(':id', $_SESSION['rexkod_user_id']);
        $results = $this->db->single();
        if(password_verify($opass, $results->password))
        {
        return true;
        }
        else
        {
        return false;
        }
    }
    public function update_password($npass, $email)
    {
        $npass = password_hash($npass, PASSWORD_DEFAULT);
        $this->db->query('UPDATE auth set password = :npass, email = :email WHERE id = :id');

        // Bind values
        $this->db->bind(':npass', $npass);
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $_SESSION['rexkod_user_id']);
        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }
    public function findUserByphno($phno)
    {
        $this->db->query('SELECT * FROM auth WHERE phone = :phno');
        // Bind values      
        $this->db->bind(':phno', $phno);
        $row = $this->db->single();
        // Check row 
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByPhone($phone)
    {
        $this->db->query('SELECT * FROM auth WHERE phone = :phno');
        // Bind values      
        $this->db->bind(':phno', $phone);
        return $this->db->single();
    }

    public function findUserByemail($email)
    {
        $this->db->query('SELECT * FROM auth WHERE email = :email');
        // Bind values      
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        // Check row 
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function findVendorByPhone($phone)
    {
        $this->db->query('SELECT * FROM vendors WHERE vendor_phone = :phone');
        // Bind values      
        $this->db->bind(':phone', $phone);
        $row = $this->db->single();
        // Check row 
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function add_user($email, $phno, $pass)
    {
        $this->db->query('INSERT INTO auth (type,email,phone,password,created_at) VALUES(:type, :email, :phno, :pass, :createdat)');
        // Bind values
        
        $this->db->bind(':type', 'user');
        $this->db->bind(':email', $email);
        $this->db->bind(':phno', $phno);
        $this->db->bind(':pass', $pass);
        $this->db->bind(':createdat', date('Y-m-d H:i:s'));
        // Execute

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }



    public function add_client($business_name,$name,$phone,$email)
    {
        $this->db->query('INSERT INTO clients (business_name,name,phone,email) VALUES(:business_name, :name,:phone,:email)');
        // Bind values
        
        $this->db->bind(':business_name', $business_name);
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phone', $phone);
        // Execute

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }


    public function add_distributor($business_name,$name,$phone,$email)
    {
        $this->db->query('INSERT INTO distributors(business_name,name,phone,email) VALUES(:business_name, :name,:phone,:email)');
        // Bind values
        
        $this->db->bind(':business_name', $business_name);
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phone', $phone);
        // Execute

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }



    public function add_project($type,$client_id,$name,$project_detail,$start_date,$end_date,$delivery_date,$manager_id,$product_name,$product_qty,$product_detail)
    {
        $this->db->query('INSERT INTO projects (type,client_id,name,project_detail,start_date,end_date,delivery_date,manager_id,product_name,product_qty,product_detail) VALUES(:type,:client_id,:name,:project_detail,:start_date,:end_date,:delivery_date,:manager_id,:product_name,:product_qty,:product_detail)');
        // Bind values
        
        $this->db->bind(':type', $type);
        $this->db->bind(':client_id', $client_id);
        $this->db->bind(':name', $name);
        $this->db->bind(':project_detail', $project_detail);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':end_date', $end_date);
        $this->db->bind(':delivery_date', $delivery_date);
        $this->db->bind(':manager_id', $manager_id);
        $this->db->bind(':product_name', $product_name);
        $this->db->bind(':product_qty', $product_qty);
        $this->db->bind(':product_detail', $product_detail);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }



    public function add_operation($name,$project_id,$manager_id,$start_date,$end_date)
    {
        $this->db->query('INSERT INTO operations (name,project_id,manager_id,start_date,end_date) VALUES(:name,:project_id,:manager_id,:start_date,:end_date)');
        // Bind values
        
        $this->db->bind(':project_id', $project_id);
        $this->db->bind(':name', $name);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':end_date', $end_date);
        $this->db->bind(':manager_id', $manager_id);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }


    public function add_attendance($user_id,$start_date,$start_time,$meal)
    {
        $this->db->query('INSERT INTO attendance (user_id,start_date,start_time,meal) VALUES(:user_id,:start_date,:start_time,:meal)');
        // Bind values
        
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':meal', $meal);
        $this->db->bind(':start_time', $start_time);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }


    public function add_attendance_mannual($data)
    {
        $this->db->query('INSERT INTO attendance (user_id,start_date,start_time,end_time,meal) VALUES(:user_id,:start_date,:start_time,:end_time,:meal)');
        // Bind values
        
    $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':meal', $data['meal']);
        $this->db->bind(':start_time', $data['start_time']);
        $this->db->bind(':end_time', $data['end_time']);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }





    public function add_task($name,$project_id,$operation_id,$user_id,$checklist,$start_date,$end_date)
    {
        $this->db->query('INSERT INTO tasks (name,project_id,operation_id,user_id,checklist,start_date,end_date) VALUES(:name,:project_id,:operation_id,:user_id,:checklist,:start_date,:end_date)');
        // Bind values
        
        
        $this->db->bind(':name', $name);
        $this->db->bind(':project_id', $project_id);
        $this->db->bind(':operation_id', $operation_id);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':checklist', $checklist);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':end_date', $end_date);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }


    public function add_product($mecwin_code,$project_id,$start_date,$end_date)
    {
        $this->db->query('INSERT INTO products (mecwin_code,project_id,start_date,end_date) VALUES(:mecwin_code,:project_id,:start_date,:end_date)');
        // Bind values
        
        
        $this->db->bind(':mecwin_code', $mecwin_code);
        $this->db->bind(':project_id', $project_id);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':end_date', $end_date);

        if ($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }



    public function add_vendor($name, $bname, $email, $phone, $pass, $address, $city, $state, $pincode, $gst, $temp, $timing, $minval, $subcat_id, $commission)
    {
        
        
        $createdat = date("Y/M/D h:i:s a", time());
        $this->db->query('INSERT INTO auth (name, type, email, phone, password, status, created_at) VALUES(:name,:type,:email, :phone, :pass, :status, :created_at)');
        // Bind values
        $this->db->bind(':name', $name);
        $this->db->bind(':type', 'vendor');
        $this->db->bind(':email', $email);
        $this->db->bind(':phone', $phone);
        $this->db->bind(':pass', $pass);
        $this->db->bind(':status', '0');
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));

        if ($this->db->execute()) {   

            $this->db->query('SELECT * FROM auth WHERE phone = :phone');
            $this->db->bind(':phone', $phone);
            $cur_user = $this->db->single();
                 
            $this->db->query('INSERT INTO vendors (vendor_id,vendor_name, vendor_address, vendor_city,vendor_state, vendor_pincode, vendor_gst, vendor_gst_cert, vendor_timing, vendor_minorder, vendor_subcategory_id, vendor_commission) VALUES(:vendorid, :name, :address, :city, :state, :pincode, :gst, :gst_cert, :timing, :minval, :subcat_id, :commission)');
            // Bind values
            $this->db->bind(':vendorid', $cur_user->id);
            $this->db->bind(':name', $bname);
            $this->db->bind(':address', $address);
            $this->db->bind(':city', $city);
            $this->db->bind(':state', $state);
            $this->db->bind(':pincode', $pincode);
            $this->db->bind(':gst', $gst);
            $this->db->bind(':gst_cert', $temp);
            $this->db->bind(':timing', $timing);
            $this->db->bind(':minval', $minval);
            $this->db->bind(':subcat_id', $subcat_id);
            $this->db->bind(':commission',$commission);
            // Execute
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }}

    }


    public function add_vendor_profile($name, $address, $city, $state, $pincode, $gst, $timing, $minval,$subcat_id)
    {

        if(!empty($_FILES['gst_cert']['name']))
        {
            $f_name = $_FILES['gst_cert']['name'];
            $f_temp = $_FILES['gst_cert']['tmp_name'];
            $size = $_FILES['gst_cert']['size'];
            $f_extension=explode('.', $f_name);
            $f_extension=strtolower(end($f_extension));
            $unqdate = date("Ymd");
            $unqtime = time();
            $unqname = $_SESSION['rexkod_vendor_id']."".$unqdate."".$unqtime;
            $f_newfile=$unqname.'.' .$f_extension;
            $store="uploads/" .$f_newfile;
            move_uploaded_file($f_temp, $store);
            $store ="uploads/";
            $temp=$f_newfile;
        }
        else
        {
            $temp = NULL;
        }

            $this->db->query('INSERT INTO vendors (vendor_id,vendor_name, vendor_address, vendor_city,vendor_state, vendor_pincode, vendor_gst, vendor_gst_cert, vendor_timing, vendor_minorder, vendor_subcategory_id) VALUES(:vendorid, :name, :address, :city, :state, :pincode, :gst, :gstcert, :timing, :minval, :subcat_id)');
            // Bind values
            $this->db->bind(':vendorid', $_SESSION['rexkod_vendor_id']);
            $this->db->bind(':name', $name);
            $this->db->bind(':address', $address);
            $this->db->bind(':city', $city);
            $this->db->bind(':state', $state);
            $this->db->bind(':pincode', $pincode);
            $this->db->bind(':gst', $gst);
            $this->db->bind(':gstcert', $temp);
            $this->db->bind(':timing', $timing);
            $this->db->bind(':minval', $minval);
            $this->db->bind(':subcat_id', $subcat_id);
            // Execute
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }

    }


    public function add_user_profile($name, $type, $address, $city, $state, $pincode, $gst)
    {

        if(!empty($_FILES['gst_cert']['name']))
        {
            $f_name = $_FILES['gst_cert']['name'];
            $f_temp = $_FILES['gst_cert']['tmp_name'];
            $size = $_FILES['gst_cert']['size'];
            $f_extension=explode('.', $f_name);
            $f_extension=strtolower(end($f_extension));
            $unqdate = date("Ymd");
            $unqtime = time();
            $unqname = $_SESSION['rexkod_user_id']."".$unqdate."".$unqtime;
            $f_newfile=$unqname.'.' .$f_extension;
            $store="uploads/" .$f_newfile;
            move_uploaded_file($f_temp, $store);
            $store ="uploads/";
            $temp=$f_newfile;
        }
        else
        {
            $temp = NULL;
        }

            $this->db->query('INSERT INTO users (user_id, user_type, user_name, user_address, user_city,user_state, user_pincode, user_country, user_gst, user_gst_cert) VALUES(:userid, :type, :name, :address, :city, :state, :pincode, :country, :gst, :gstcert)');
            // Bind values
            $this->db->bind(':userid', $_SESSION['rexkod_user_id']);
            $this->db->bind(':name', $name);
            $this->db->bind(':type', $type);
            $this->db->bind(':address', $address);
            $this->db->bind(':city', $city);
            $this->db->bind(':state', $state);
            $this->db->bind(':country', 'India');
            $this->db->bind(':pincode', $pincode);
            $this->db->bind(':gst', $gst);
            $this->db->bind(':gstcert', $temp);
            // Execute
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }

    }



  


      // Get Post By ID
      public function getVendorById($id){
        $this->db->query('SELECT * FROM vendors WHERE vendor_id = :id');
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
  
        return $row;
      }


      public function get_pump($id){
        $this->db->query('SELECT * FROM bore_main WHERE id = :id');
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
  
        return $row;
      }




      public function get_attendance_date($id,$date){
        $this->db->query('SELECT * FROM attendance WHERE user_id = :id AND start_date=:date');
  
        $this->db->bind(':id', $id);
        $this->db->bind(':date', $date);
        $row = $this->db->single();
  
        return $row;
      }
      public function delete_attendance($id){
          $this->db->query('DELETE FROM attendance where id=:id');
          $this->db->bind(':id', $id);
          if($this->db->execute()){
            return true;
          } else {
            return false;
          }

          
      }
      public function select_cl_date($id,$date){
        $this->db->query('SELECT * FROM leaves WHERE user_id = :id AND type=:type AND status=:status AND  :date BETWEEN start_date AND end_date');
  
        $this->db->bind(':id', $id);
        $this->db->bind(':date', $date);
        $this->db->bind(':status', '1');
        $this->db->bind(':type', '1');
        $row = $this->db->single();
        return $row;
      }
      public function select_el_date($id,$date){
        $this->db->query('SELECT * FROM leaves WHERE user_id = :id AND type=:type AND status=:status AND  :date BETWEEN start_date AND end_date');
  
        $this->db->bind(':id', $id);
        $this->db->bind(':date', $date);
        $this->db->bind(':status', '1');
        $this->db->bind(':type', '2');
        $row = $this->db->single();
        return $row;
      }
      public function select_sl_date($id,$date){
        $this->db->query('SELECT * FROM leaves WHERE user_id = :id AND type=:type AND  status=:status AND  :date BETWEEN start_date AND end_date');
  
        $this->db->bind(':id', $id);
        $this->db->bind(':date', $date);
        $this->db->bind(':status', '1');
        $this->db->bind(':type', '3');
        $row = $this->db->single();
        return $row;
      }
      public function select_od_date($id,$date){
        $this->db->query('SELECT * FROM leaves WHERE user_id = :id AND type=:type AND  status=:status AND  :date BETWEEN start_date AND end_date');
  
        $this->db->bind(':id', $id);
        $this->db->bind(':date', $date);
        $this->db->bind(':status', '1');
        $this->db->bind(':type', '4');
        $row = $this->db->single();
        return $row;
      }

      public function get_meal($meal,$date){
        $this->db->query('SELECT * FROM attendance WHERE start_date=:date AND meal = :meal');
        $this->db->bind(':meal', $meal);
        $this->db->bind(':date', $date);
        $row = $this->db->resultSet();
        return $row;
      }


      public function getOrderById($id){
        $this->db->query('SELECT * FROM orders WHERE order_id = :id');
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
  
        return $row;
      }



      public function getTcsById($id){
        $this->db->query('SELECT * FROM tcs_certificate WHERE tcs_id = :id');
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
  
        return $row;
      }



      public function getOrderDetailById($id){
        $this->db->query('SELECT * FROM product_order_list WHERE p_id = :id');
  
        $this->db->bind(':id', $id);
        
        $row = $this->db->resultSet();
  
        return $row;
      }

      
  
  
      // Update Post
      public function updateVendor($data){
        // Prepare Query
        $this->db->query('UPDATE testimonials SET name = :name, designation = :designation, content = :content WHERE id = :id');
  
        // Bind Values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':designation', $data['designation']);
        $this->db->bind(':content', $data['content']);
        
        //Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }



           // Update Post
           public function update_attendance($id,$end_date,$end_time){
            // Prepare Query
            $this->db->query('UPDATE attendance SET end_date = :end_date, end_time = :end_time WHERE id = :id');
      
            // Bind Values
            $this->db->bind(':id', $id);
            $this->db->bind(':end_date', $end_date);
            $this->db->bind(':end_time', $end_time);
            
            //Execute
            if($this->db->execute()){
              return true;
            } else {
              return false;
            }
          }
  
      // Delete Post
      public function deleteVendor($id){
        // Prepare Query
        $this->db->query('DELETE FROM testimonials WHERE id = :id');
  
        // Bind Values
        $this->db->bind(':id', $id);
        
        //Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }


    public function ulogin($email, $pass)
    {
        $this->db->query('SELECT * FROM auth WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        $hashed_password = $row->password;

        if (password_verify($pass, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }
    public function get_single_product($val)
    {
        $this->db->query('SELECT * FROM products WHERE id = :val');
        $this->db->bind(':val', $val);
        return $this->db->single();
    }

    public function add_item_to_cart_db($data)
    {

        $this->db->query('SELECT * FROM cart WHERE item_id = :id AND created_by = :uid');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':uid', $_SESSION['rexkod_user_id']);
        $x = $this->db->single();
        
        $x1 = 0;
        $qt = 0;
        if ($x) 
        {
            $qt = (int)$data['qty'];
            $p1 = (float)$data['price'];
            $x1 = (float)$data['total'];
            $this->db->query('UPDATE cart SET item_qty=:qty, item_price=:price, item_total_price=:total WHERE id=:id');
            $this->db->bind(':id', $x->id);
            $this->db->bind(':qty', $qt);
            $this->db->bind(':price', $p1);
            $this->db->bind(':total', $x1);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->query('INSERT INTO cart(item_id, item_name, item_qty, item_price, item_total_price, created_by,img,prod_vendorId,prod_vendorName) VALUES (:id,:name,:qty,:price,:total,:created_by,:img,:prod_vendorId,:prod_vendorName)');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':qty', $data['qty']);
            $this->db->bind(':price', $data['price']);
            $this->db->bind(':total', $data['total']);
            $this->db->bind(':created_by', $data['created_by']);
            $this->db->bind(':img', $data['img']);

            $this->db->bind(':prod_vendorId', $data['created_byId']);
            $this->db->bind(':prod_vendorName', $data['created_byType']);


            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_sum_cart()
    {
        $this->db->query('SELECT * FROM cart WHERE created_by =:created_by');
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        $x = $this->db->resultSet();
        $a = 0;
        foreach ($x as $k) {
            $a = $a + $k->item_total_price;
        }
        return $a;
    }
    public function getcart_items()
    {
        $this->db->query('SELECT * FROM cart WHERE created_by=:created_by');
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        return $this->db->resultSet();
    }




    public function getSubcategoryById($id)
    {
        $this->db->query("SELECT * FROM subcategory where subcategory_id = :id ");

        $this->db->bind(':id', $id);

        return $results = $this->db->single();
    }




    public function get_cart_user_check()
    {
        $this->db->query('SELECT * FROM cart WHERE created_by=:usid');
        $this->db->bind(':usid', $_SESSION['rexkod_user_id']);
        return $this->db->resultSet();
        
    }
    
    public function get_cart_vendor_check($vid)
    {
        $this->db->query('SELECT * FROM cart WHERE prod_vendorId=:vid');
        $this->db->bind(':vid', $vid);
        return $this->db->resultSet();
        
    }


    public function getCategoryById($id)
    {
        $this->db->query("SELECT * FROM category where category_id = :id ");

        $this->db->bind(':id', $id);

        return $results = $this->db->single();
    }


    public function delete_cart_item_db($id)
    {
        $this->db->query("DELETE FROM cart WHERE id=:id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function clear_cart_item_db($id)
    {
        $this->db->query("DELETE FROM cart WHERE created_by=:id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getcart_items_by_item_id($item_id)
    {
        $this->db->query('SELECT * FROM cart WHERE item_id=:item_id AND created_by=:created_by');
         $this->db->bind(':item_id', $item_id);
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        return $this->db->single();
    }
    public function delete_item_to_cart_db($data)
    {
        $this->db->query('UPDATE cart SET item_qty=:qty, item_total_price=:total, item_price=:item_price WHERE id=:id AND created_by=:created_by');
        $this->db->bind(':id', $data['cart_id']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':item_price', $data['price']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
     public function delete_item_to_cart_db_if_zero($data)
    {
        $this->db->query("DELETE FROM cart WHERE id = :id AND created_by=:created_by");
        $this->db->bind(':id', $data['cart_id']);
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function convert_temp_id_to_user_id_for_pcart()
    {
        $d ='';
        $this->db->query('SELECT * FROM cart WHERE created_by =:created_by');
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id_rec']);
        $x = $this->db->resultSet();
        foreach ($x as $k) 
        {
            $this->db->query('UPDATE cart SET created_by=:created_by WHERE id=:id');
            $this->db->bind(':id', $k->id);
            $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
            $d = $this->db->execute();
        }
        if ($d) {
            return true;
        } else {
            return false;
        }
    }




    public function get_employee($id)
    {
        $this->db->query("select * from users where mec_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }

    public function get_technicians()
    {
        $this->db->query("select * from users where designation = :designation");
        $this->db->bind(':designation', "Technician");
        return $results = $this->db->resultSet();
    }

    public function get_userinfo($id)
    {
        $this->db->query("select * from users where mec_id = :id");
        $this->db->bind(':id', $id);
        return $results = $this->db->single();
    }

    public function get_cams()
    {
        $this->db->query("SELECT * FROM cams ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }



    public function get_employees()
    {
        $this->db->query("select * from users ORDER BY user_id DESC");
        return $results = $this->db->resultSet();
    }
    public function get_enabled_employees()
    {
        $this->db->query("select * from users where employee_status=:status ORDER BY user_id DESC");
        $this->db->bind(':status', '0');
        return $results = $this->db->resultSet();
    }
    public function get_disabled_employees()
    {
        $this->db->query("select * from users where employee_status=:status ORDER BY user_id DESC");
        $this->db->bind(':status', '1');
        return $results = $this->db->resultSet();
    }

    public function get_employee_by_search($search_input)

    {
        $this->db->query('SELECT * FROM users WHERE employee_name LIKE concat("%", :search_input, "%")');

        
        $this->db->bind(':search_input', $search_input);

        return $row = $this->db->resultSet();
    }

    public function get_managers()
    {
        $this->db->query("select * from users WHERE designation =:designation ORDER BY user_id DESC");
        $this->db->bind(':designation', 'Manager');
        return $results = $this->db->resultSet();
    }


    public function get_users()
    {
        $this->db->query("select * from users");
        return $results = $this->db->resultSet();
    }
    public function get_users_status()
    {
        $this->db->query("select * from users where employee_status LIKE :status");
        $this->db->bind(':status', '0');
        return $results = $this->db->resultSet();
    }
    public function get_perm_users_status()
    {
        $this->db->query('select * from users where employee_status=:status AND employment_type=:type');
        $this->db->bind(':status', '0');
        $this->db->bind(':type', 'ONROLE');
        return $results = $this->db->resultSet();
    }
    public function get_contr_users_status()
    {
        $this->db->query("select * from users where employee_status=:status AND employment_type!=:type");
        $this->db->bind(':status', '0');
        $this->db->bind(':type', 'ONROLE');
        return $results = $this->db->resultSet();
    }

    public function get_tickets()
    {
        $this->db->query("SELECT * FROM tickets ORDER BY ticket_id DESC");
        return $results = $this->db->resultSet();
    }


    public function get_clients()
    {
        $this->db->query("SELECT * FROM clients ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }


    public function get_distributors()
    {
        $this->db->query("SELECT * FROM distributors ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }


    public function get_projects()
    {
        $this->db->query("SELECT * FROM projects ORDER BY id DESC");
        return $results = $this->db->resultSet();
    }

    public function get_operations($id)
    {
        $this->db->query("SELECT * FROM operations WHERE project_id=:id ORDER BY id DESC");
        $this->db->bind(':id', $id);
        return $results = $this->db->resultSet();
    }


    public function get_salary($id)
    {
        $this->db->query("SELECT * FROM salary WHERE Emp_Id=:id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }
    public function get_count_cl($id,$start_date,$end_date){
        $this->db->query("SELECT SUM(number_of_days) as value_sum FROM leaves WHERE user_id=:id  AND  type=:type AND  start_date>=:start_date AND end_date <= :end_date ");
        $this->db->bind(':id', $id);
        $this->db->bind(':type', '1');
        $this->db->bind(':start_date',$start_date);
        $this->db->bind(':end_date', $end_date);
        $row = $this->db->single();
        return $row;
    }
    public function get_count_el($id,$start_date,$end_date){
        $this->db->query("SELECT SUM(number_of_days) as value_sum FROM leaves WHERE user_id=:id  AND  type=:type AND  start_date>=:start_date AND end_date <= :end_date ");
        $this->db->bind(':id', $id);
        $this->db->bind(':type', '2');
        $this->db->bind(':start_date',$start_date);
        $this->db->bind(':end_date', $end_date);
        $row = $this->db->single();
        return $row;
    }
    public function get_count_sl($id,$start_date,$end_date){
        $this->db->query("SELECT SUM(number_of_days) as value_sum FROM leaves WHERE user_id=:id  AND  type=:type AND  start_date>=:start_date AND end_date <= :end_date ");
        $this->db->bind(':id', $id);
        $this->db->bind(':type', '3');
        $this->db->bind(':start_date',$start_date);
        $this->db->bind(':end_date', $end_date);
        $row = $this->db->single();
        return $row;
    }
    public function get_count_od($id,$start_date,$end_date){
        $this->db->query("SELECT SUM(number_of_days) as value_sum FROM leaves WHERE user_id=:id  AND  type=:type AND  start_date>=:start_date AND end_date <= :end_date ");
        $this->db->bind(':id', $id);
        $this->db->bind(':type', '4');
        $this->db->bind(':start_date',$start_date);
        $this->db->bind(':end_date', $end_date);
        $row = $this->db->single();
        return $row;
    }

    public function update_salary($data)
    {

        $this->db->query('UPDATE salary set Basic_DA = :Basic_DA,PAN=:PAN, HRA = :HRA, Washing_Allowance=:Washing_Allowance,Telephonic_Allowance=:Telephonic_Allowance,Other_Allowance=:Other_Allowance,Incentive=:Incentive, Earned_Gross=:Earned_Gross, Arrears=:Arrears, PF=:PF, ESI_No=:ESI_No, ESI=:ESI, PT=:PT, Advance=:Advance, Loan=:Loan, TDS=:TDS, Canteen=:Canteen, Other_Deduction=:Other_Deduction, Total_Deduction=:Total_Deduction,cl=:cl, sl=:sl,el=:el,od=:od,UAN=:uan WHERE Emp_Id= :id');
        // Bind values
        $this->db->bind(':id', $data['Emp_Id']);
        $this->db->bind(':Basic_DA', $data['Basic_DA']);
        
        $this->db->bind(':PAN', $data['PAN']);
        $this->db->bind(':HRA', $data['HRA']);
        $this->db->bind(':Washing_Allowance', $data['Washing_Allowance']);
        $this->db->bind(':Telephonic_Allowance', $data['Telephonic_Allowance']);
        $this->db->bind(':Other_Allowance', $data['Other_Allowance']);
        $this->db->bind(':Incentive', $data['Incentive']);
        
         $this->db->bind(':Arrears', $data['Arrears']);
        
         $this->db->bind(':ESI_No', $data['ESI_No']);
         
         
         $this->db->bind(':Advance', $data['Advance']);
         $this->db->bind(':Loan', $data['Loan']);
         $this->db->bind(':TDS', $data['TDS']);
         $this->db->bind(':Canteen', $data['Canteen']);
         $this->db->bind(':Other_Deduction', $data['Other_Deduction']);
        
         $this->db->bind(':cl', $data['cl']);
         $this->db->bind(':el', $data['el']);
         $this->db->bind(':sl', $data['sl']);
         $this->db->bind(':od', $data['od']);
         $this->db->bind(':uan', $data['UAN']);
             $allowances_pf = intval($_POST['Basic_DA'])+intval($_POST['Washing_Allowance'])+ intval($_POST['Telephonic_Allowance'])+intval($_POST['Other_Allowance']);
         $allowances_esi = intval($_POST['Basic_DA'])+intval($_POST['HRA'])+ intval($_POST['Telephonic_Allowance'])+intval($_POST['Other_Allowance']);
         $earned_gross= intval($_POST['Basic_DA'])+intval($_POST['Washing_Allowance'])+ intval($_POST['Telephonic_Allowance'])+intval($_POST['Other_Allowance'])+intval($_POST['HRA'])+intval($_POST['Arrears'])+intval($_POST['Incentive']);
         if($allowances_pf>=15000){
             $PF = 1800;
         }else{$PF = $allowances_pf*(12/100);
         }
         if($allowances_esi>=21000){
             $ESI = 0;
         }else{
            $ESI = $allowances_esi*(0.75/100);
         }
         if($_POST['Earned_Gross']>=15000){
             $PT = 200;
         }else{
             $PT = 0;
         }
         $total_deduction = intval($ESI) + intval($PT) + intval($_POST['Advance']) + intval($_POST['Loan']) + intval($_POST['Canteen'])+ intval($data['Other_Deduction']) + intval($PF)+intval($_POST['TDS']);
         $this->db->bind(':Total_Deduction',  round($total_deduction, 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':PF', round($PF, 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':ESI',round($ESI, 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':PT', round($PT, 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':Earned_Gross', round($earned_gross, 0, PHP_ROUND_HALF_UP));
        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }
    public function add_db_salary($data)
    {
        
        $this->db->query("select * from users where mec_id = :id");
        $this->db->bind(':id', $data['Emp_Id']);
        
         $results = $this->db->single();
         $employee_name = $results->employee_name;

        $this->db->query('INSERT INTO salary (Emp_Id,Name,Basic_DA,PAN, HRA, Washing_Allowance,Telephonic_Allowance,Other_Allowance,Incentive, Earned_Gross, Arrears, PF, ESI_No, ESI, PT, Advance, Loan, TDS, Canteen, Other_Deduction, Total_Deduction,cl, sl,el,od,UAN) VALUES (:id,:Name,:Basic_DA,:PAN, :HRA, :Washing_Allowance,:Telephonic_Allowance,:Other_Allowance,:Incentive, :Earned_Gross, :Arrears, :PF, :ESI_No, :ESI, :PT, :Advance, :Loan, :TDS, :Canteen, :Other_Deduction, :Total_Deduction,:cl, :sl,:el,:od,:UAN) ');
        // Bind values
        // echo $data['Basic_DA'];
        // die();
        
        $this->db->bind(':Basic_DA', $data['Basic_DA']);
        $this->db->bind(':id', $data['Emp_Id']);
        $this->db->bind(':Name', $employee_name);
        $this->db->bind(':PAN', $data['PAN']);
        $this->db->bind(':HRA', $data['HRA']);
        $this->db->bind(':Washing_Allowance', $data['Washing_Allowance']);
        $this->db->bind(':Telephonic_Allowance', $data['Telephonic_Allowance']);
        $this->db->bind(':Other_Allowance', $data['Other_Allowance']);
        $this->db->bind(':Incentive', $data['Incentive']);
         $this->db->bind(':Earned_Gross', round($data['Earned_Gross'], 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':Arrears', $data['Arrears']);
         $this->db->bind(':PF', round($data['PF'], 0, PHP_ROUND_HALF_UP));
         $this->db->bind(':ESI_No', $data['ESI_No']);
         $this->db->bind(':ESI',$data['ESI']);
         $this->db->bind(':PT', $data['PT']);
         $this->db->bind(':Advance', $data['Advance']);
         $this->db->bind(':Loan', $data['Loan']);
         $this->db->bind(':TDS', $data['TDS']);
         $this->db->bind(':Canteen', $data['Canteen']);
         $this->db->bind(':Other_Deduction', $data['Other_Deduction']);

         $this->db->bind(':Total_Deduction', $data['Total_Deduction']);

         $this->db->bind(':cl', $data['cl']);
         $this->db->bind(':el', $data['el']);
         $this->db->bind(':sl', $data['sl']);
         $this->db->bind(':od', $data['od']);
         $this->db->bind(':UAN', $data['UAN']);


        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }


    public function update_profile($data)
    {
        $this->db->query('UPDATE users set employee_name = :employee_name, designation = :designation, department=:department,branch=:branch,date_of_joining=:date_of_joining,employment_type=:employment_type, cell_number=:cell_number, company_email=:company_email, date_of_birth=:date_of_birth, current_address=:current_address, gender=:gender, blood_group=:blood_group, reports_to=:reports_to WHERE mec_id = :id');
        // Bind values
        $this->db->bind(':id', $data['mec_id']);
        $this->db->bind(':employee_name', $data['employee_name']);
        $this->db->bind(':designation', $data['designation']);
        $this->db->bind(':department', $data['department']);
        $this->db->bind(':branch', $data['branch']);
        $this->db->bind(':date_of_joining', $data['date_of_joining']);
        $this->db->bind(':employment_type', $data['employment_type']);
         $this->db->bind(':cell_number', $data['cell_number']);
         $this->db->bind(':company_email', $data['company_email']);
         $this->db->bind(':date_of_birth', $data['date_of_birth']);
         $this->db->bind(':current_address', $data['current_address']);
         $this->db->bind(':gender', $data['gender']);
         $this->db->bind(':blood_group', $data['blood_group']);
         $this->db->bind(':reports_to', $data['reports_to']);
         


        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }

    public function update_basic_profile($data)
    {
        $this->db->query('UPDATE users set passport_number = :passport_number, date_of_issue = :date_of_issue, valid_upto=:valid_upto,permanent_address=:permanent_address,personal_email=:personal_email, marital_status=:marital_status, qualification=:qualification, person_to_be_contacted=:person_to_be_contacted, relation=:relation, emergency_phone_number=:emergency_phone_number, bank_name=:bank_name, bank_ac_no=:bank_ac_no, ifsc_code=:ifsc_code, leave_policy=:leave_policy, default_shift=:default_shift, salary_mode=:salary_mode, cl=:cl, sl=:sl, el=:el, leave_approver=:leave_approver WHERE mec_id = :id');
        // Bind values
        $this->db->bind(':id', $data['mec_id']);
        $this->db->bind(':passport_number', $data['passport_number']);
        $this->db->bind(':date_of_issue', $data['date_of_issue']);
        $this->db->bind(':valid_upto', $data['valid_upto']);
        $this->db->bind(':permanent_address', $data['permanent_address']);
        $this->db->bind(':personal_email', $data['personal_email']);
         $this->db->bind(':marital_status', $data['marital_status']);
         $this->db->bind(':qualification', $data['qualification']);
         $this->db->bind(':person_to_be_contacted', $data['person_to_be_contacted']);
         $this->db->bind(':relation', $data['relation']);
         $this->db->bind(':emergency_phone_number', $data['emergency_phone_number']);
         $this->db->bind(':bank_name', $data['bank_name']);
         $this->db->bind(':bank_ac_no', $data['bank_ac_no']);
         $this->db->bind(':ifsc_code', $data['ifsc_code']);
         $this->db->bind(':leave_policy', $data['leave_policy']);
         $this->db->bind(':default_shift', $data['default_shift']);
         $this->db->bind(':salary_mode', $data['salary_mode']);
         $this->db->bind(':cl', $data['cl']);
         $this->db->bind(':sl', $data['sl']);
         $this->db->bind(':el', $data['el']);
         $this->db->bind(':leave_approver', $data['leave_approver']);
         


        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }
    
    public function get_products($id)
    {
        $this->db->query("SELECT * FROM products WHERE project_id=:id ORDER BY id DESC");
        $this->db->bind(':id', $id);
        return $results = $this->db->resultSet();
    }


    public function get_tasks($id)
    {
        $this->db->query("SELECT * FROM tasks WHERE operation_id=:id ORDER BY id DESC");
        $this->db->bind(':id', $id);
        return $results = $this->db->resultSet();
    }


    public function get_user_tasks($id)
    {
        $this->db->query("SELECT * FROM tasks WHERE user_id=:id ORDER BY id DESC");
        $this->db->bind(':id', $id);
        return $results = $this->db->resultSet();
    }



    public function ulogin_using_rowId($id)
    {
        $this->db->query('SELECT * FROM vendors WHERE vendor_id = :vendor_id');
        $this->db->bind(':vendor_id', $id);
        $row = $this->db->single();

        return $row;
    }


    public function get_project($id)
    {
        $this->db->query('SELECT * FROM projects WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }



    public function get_operation($id)
    {
        $this->db->query('SELECT * FROM operations WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }


    public function get_task($id)
    {
        $this->db->query('SELECT * FROM tasks WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }




          public function get_all_userinfo()
    {
        $this->db->query("SELECT * FROM auth where id = :id");

        $this->db->query("SELECT *
        FROM auth
        INNER JOIN users 
        ON auth.id = users.user_id
        WHERE auth.id=:id
        ;");

        $this->db->bind(':id', $_SESSION['rexkod_user_id']);
        $row = $this->db->single();

        return $row;
    }


    public function get_sum_cart_for_payment()
    {
        $this->db->query('SELECT * FROM cart WHERE created_by =:created_by');
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        $x = $this->db->resultSet();
        $a = 0;
        foreach ($x as $k) {
            $a = $a + $k->item_total_price;
        }
        return $a;
    }
    public function savecookies()
    {

        $this->db->query('UPDATE auth SET temp_id = :order_id, temp_data = :temp_data WHERE id = :user_id');
        $this->db->bind(':order_id', $_SESSION['order_id']);
        $this->db->bind(':temp_data', $_SESSION['temp_data']);
        $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function gettempdate($order_id)
    {
        $this->db->query('SELECT * FROM auth WHERE temp_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $results = $this->db->single();
    }
    public function add_cart_for_payment($name, $email, $phno, $add, $city, $state, $zipcode, $country, $data)
    {
        $order_d = array();
        $tempID = md5(uniqid(rand(), true));
        $this->db->query('INSERT INTO orders (name, email,phone, address, city, state, zipcode, country,user_id,img,temp_id,pay_status,invoice_exsist, last_updatedAt, last_updatedBy) VALUES(:name, :email, :phno, :add, :city, :state, :zipcode, :country, :user_id, :img, :temp_id,1,1, :last_updatedAt, :last_updatedBy)');



        // Bind values
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phno', $phno);
        $this->db->bind(':add', $add);
        $this->db->bind(':city', $city);
        $this->db->bind(':state', $state);
        $this->db->bind(':zipcode', $zipcode);
        $this->db->bind(':country', $country);
        $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        $this->db->bind(':img', '');
        $this->db->bind(':temp_id', $tempID);
        $this->db->bind(':last_updatedAt', date('d-m-Y h:i'));
        $this->db->bind(':last_updatedBy', $_SESSION['rexkod_user_id']);

        // Execute
        if ($this->db->execute()) {
            $this->db->query('SELECT id FROM orders WHERE temp_id = :temp_id');
            $this->db->bind(':temp_id', $tempID);
            $temp = $this->db->single();

            $this->db->query('SELECT * FROM cart WHERE created_by =:created_by');
            $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
            $x = $this->db->resultSet();
            foreach ($x as $k) 
            {
                $s = '';
                $this->db->query('INSERT INTO product_order_list(item_id, item_name, item_qty, item_price, item_total_price, created_by, p_id,p_img) VALUES (:id,:name,:qty,:price,:total,:created_by,:p_id,:p_img)');
                $this->db->bind(':id', $k->item_id);
                $this->db->bind(':name', $k->item_name);
                $this->db->bind(':qty', $k->item_qty);
                $this->db->bind(':price', $k->item_price);
                $this->db->bind(':total', $k->item_total_price);
                $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
                $this->db->bind(':p_id', $temp->id);
                $this->db->bind(':p_img', $k->img);
                $xq = $this->db->execute();
                $s = $k->item_id . "|" . $k->item_name . "|" . $k->item_qty . "|" . $k->item_price;
                $order_d[] = $s;
            }
            $order_d = implode("!", $order_d);
            $this->db->query('INSERT INTO product_invoice (booking_id, name, order_details, sub_total, total, pharmacy_med) VALUES(:booking_id, :name, :order_details, :sub_total, :grand_total, 1)');

            $this->db->bind(':booking_id', $temp->id);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':order_details', $order_d);
            $this->db->bind(':sub_total', $data['tprice']);
            $this->db->bind(':grand_total', $data['tprice']);
            $xq1 = $this->db->execute();

            $this->db->query("UPDATE orders SET price = :grand_total where id = :id");
            $this->db->bind(':id', $temp->id);
            $this->db->bind(':grand_total', $data['tprice']);
            $this->db->execute();

            if ($xq1) {
                $this->db->query('INSERT INTO payment (name, email, ph_no, order_id, transaction_id, price, book_id, status, razorpay_order_id, razorpay_signature) VALUES(:name, :email, :phno, :order_id, :transaction_id, :price, :temp_id, 1, :razorpay_order_id, :razorpay_signature)');
                $this->db->bind(':order_id', $data['ORDERID']);
                $this->db->bind(':transaction_id', $data['TXNID']);
                $this->db->bind(':name', $data['name']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':phno', $data['phone']);
                $this->db->bind(':price', $data['tprice']);
                $this->db->bind(':temp_id', $temp->id);
                $this->db->bind(':razorpay_order_id', $data['razorpay_order_id']);
                $this->db->bind(':razorpay_signature', $data['razorpay_signature']);
                $this->db->execute();

                $this->db->query("DELETE FROM cart WHERE created_by=:created_by");
                $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
                $dd = $this->db->execute();
                if ($dd) 
                {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            die('Error');
        }
    }



    public function update_user($name, $email, $phno, $address, $pincode, $state, $country, $id)
    {


        $this->db->query('UPDATE auth SET name = :name, email = :email, phone = :phno,address = :address,pin_code = :pincode,state = :state,country = :country WHERE id = :id');

        // Bind values
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phno', $phno);

        $this->db->bind(':address', $address);
        $this->db->bind(':pincode', $pincode);
        $this->db->bind(':state', $state);
        $this->db->bind(':country', $country);
        $this->db->bind(':id', $id);
        // Execute

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function change_heart_func($prod_id, $count)
    {
        $this->db->query('UPDATE products SET very_good=:very_good WHERE id=:id');

        $this->db->bind(':id', $prod_id);
        $this->db->bind(':very_good', $count);

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }


    public function return_order($id)
    {
        $this->db->query('UPDATE orders SET return_status=:returnstatus WHERE id=:id');

        $this->db->bind(':id', $id);
        $this->db->bind(':returnstatus', 1);

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }



    public function update_cartCoupon($id)
    {
        $this->db->query('UPDATE cart SET coupon_id=:coup_id WHERE created_by=:uid');

        $this->db->bind(':uid', $_SESSION['rexkod_user_id']);
        $this->db->bind(':coup_id', $id);

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function change_good_func($prod_id, $count)
    {
        $this->db->query('UPDATE products SET good=:good WHERE id=:id');

        $this->db->bind(':id', $prod_id);
        $this->db->bind(':good', $count);

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function change_not_good_func($prod_id, $count)
    {
        $this->db->query('UPDATE products SET not_good=:not_good WHERE id=:id');

        $this->db->bind(':id', $prod_id);
        $this->db->bind(':not_good', $count);

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    public function change_status($id,$st)
    {
        $assign_time = date("d-M-Y h:i A");

        $this->db->query('UPDATE orders set status = :status, last_updatedAt = :updated_at, last_updatedBy = :user_id WHERE id = :id');
        // Bind values
        $this->db->bind(':status', $st);
        $this->db->bind(':id', $id);
        $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        $this->db->bind(':updated_at', $assign_time);


        if($this->db->execute())
        {
          return true;
        }
        else
        {
          return false;
        }
    }

     public function get_all_address() {
        $this->db->query('SELECT * FROM user_address WHERE user_id = :user_id');
         $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        $result = $this->db->resultSet();
        return $result;
    }



    public function get_tcs() {
        $this->db->query('SELECT * FROM tcs_certificate WHERE tcs_user_id = :user_id');
         $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        $result = $this->db->resultSet();
        return $result;
    }


    public function get_surveys() {
        $this->db->query('SELECT * FROM surveys ORDER BY survey_id DESC');
        $result = $this->db->resultSet();
        return $result;
    }



    public function checkout_coupons($vid,$sid) {
        $this->db->query('SELECT * FROM coupons WHERE coupon_vendor_id = :vid OR coupon_subcategory_id = :sid');
        $this->db->bind(':vid', $vid);
        $this->db->bind(':sid', $sid);
        $result = $this->db->resultSet();
        return $result;
    }



    public function insert_more_address($address, $pincode, $state, $country)
    {
        $assign_time = date("d-M-Y h:i A");

        $this->db->query('INSERT INTO user_address (address, state, zipcode, country, created_at, user_id) VALUES(:address, :state, :zipcode, :country, :created_at, :user_id)');
        // Bind values

        $this->db->bind(':address', $address);
        $this->db->bind(':zipcode', $pincode);
        $this->db->bind(':state', $state);
        $this->db->bind(':country', $country);
        $this->db->bind(':user_id', $_SESSION['rexkod_user_id']);
        $this->db->bind(':created_at', $assign_time);
        // Execute

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }



    public function add_ticket($ticket_type,$ticket_priority,$ticket_reason,$customer_name,$customer_phone,$customer_address,$dealer_name,$dealer_phone,$product_type,$product_name,$product_retting,$product_serial_number,$product_warranty,$replaced_serial_number,$technician_id)
    {
        $this->db->query('INSERT INTO tickets (ticket_type,ticket_priority,ticket_reason,customer_name,customer_phone,customer_address,dealer_name,dealer_phone,product_type,product_name,product_retting,product_serial_number,product_warranty,replaced_serial_number,technician_id) VALUES(:ticket_type,:ticket_priority,:ticket_reason,:customer_name,:customer_phone,:customer_address,:dealer_name,:dealer_phone,:product_type,:product_name,:product_retting,:product_serial_number,:product_warranty,:replaced_serial_number,:technician_id)');
        // Bind values

        $this->db->bind(':ticket_type', $ticket_type);
        $this->db->bind(':ticket_priority', $ticket_priority);
        $this->db->bind(':ticket_reason', $ticket_reason);
        $this->db->bind(':customer_name', $customer_name);
        $this->db->bind(':customer_phone', $customer_phone);
        $this->db->bind(':customer_address', $customer_address);
        $this->db->bind(':dealer_name', $dealer_name);
        $this->db->bind(':dealer_phone', $dealer_phone);
        $this->db->bind(':product_type', $product_type);
        $this->db->bind(':product_name', $product_name);
        $this->db->bind(':product_retting', $product_retting);
        $this->db->bind(':product_serial_number', $product_serial_number);
        $this->db->bind(':product_warranty', $product_warranty);
        $this->db->bind(':replaced_serial_number', $replaced_serial_number);
        $this->db->bind(':technician_id', $technician_id);

        // Execute

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_address_by_id($id)
    {
        $this->db->query('SELECT * FROM user_address WHERE id = :id');

        $this->db->bind(':id', $id);

        return $results = $this->db->single();
    }


    public function cart_active_coupon($id)
    {
        $this->db->query('SELECT * FROM coupons WHERE coupon_id = :id');

        $this->db->bind(':id', $id);

        return $results = $this->db->single();
    }




    public function make_primary_address($address, $pincode, $state, $country, $id)
    {


        $this->db->query('UPDATE auth SET address = :address,pin_code = :pincode,state = :state,country = :country WHERE id = :id');

        // Bind values
        
        $this->db->bind(':address', $address);
        $this->db->bind(':pincode', $pincode);
        $this->db->bind(':state', $state);
        $this->db->bind(':country', $country);
        $this->db->bind(':id', $id);
        // Execute

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_address_by_id($id)
    {
        $this->db->query("DELETE FROM user_address WHERE id=:id");
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function change_QR($img)
    {        
        $this->db->query('UPDATE auth SET qr_img = :qr_img WHERE id = :id');

        $this->db->bind(':id', $_SESSION['rexkod_user_id']);

        $this->db->bind(':qr_img', $img);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function update_orderFeedback($feedback, $order_id)
    {
        $this->db->query('UPDATE orders SET feedback=:feedback, feedback_status=:feedback_status WHERE id=:id');
        $this->db->bind(':feedback', $feedback);
        $this->db->bind(':feedback_status', 1);
        $this->db->bind(':id', $order_id);
  

        if ($this->db->execute()) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    } 


    public function add_cart_for_paymentPayAtdel($name, $email, $phno, $add, $city, $state, $zipcode, $country, $data, $data_checkout)
    {
        
        $this->db->query('INSERT INTO orders (name, email, phone, address, city, state, zipcode, country,vendor_id, user_id, sub_total, coupon_id, coupon_value, total, buyer_protection, tax_percentage, tax_value, shipping, net_total, created_at) VALUES(:name, :email, :phno, :add, :city, :state, :zipcode, :country, :vendorid, :userid, :subtotal, :couponid, :couponval, :total, :buyerpro, :taxpercentage, :taxval, :shipping, :nettotal, :createdat)');

        // Bind values
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':phno', $phno);
        $this->db->bind(':add', $add);
        $this->db->bind(':city', $city);
        $this->db->bind(':state', $state);
        $this->db->bind(':zipcode', $zipcode);
        $this->db->bind(':country', $country);
        $this->db->bind(':vendorid', $data_checkout->vendor_checkout);
        $this->db->bind(':userid', $_SESSION['rexkod_user_id']);
        $this->db->bind(':subtotal', $data_checkout->subtotal_checkout);
        $this->db->bind(':couponid', $data_checkout->coupon_checkout);
        $this->db->bind(':couponval', $data_checkout->coupon_value_checkout);
        $this->db->bind(':total', $data_checkout->total_checkout);
        $this->db->bind(':buyerpro', $data_checkout->buypro_checkout);
        $this->db->bind(':taxpercentage', $data_checkout->tax_Percentage_checkout);
        $this->db->bind(':taxval', $data_checkout->tax_value_checkout);
        $this->db->bind(':shipping', $data_checkout->shipping_checkout);
        $this->db->bind(':nettotal', $data_checkout->net_total); 
        $this->db->bind(':createdat', date('Y-m-d H:i:s')); 
        

        // Execute
        if ($this->db->execute()) {

            $this->db->query('SELECT id FROM orders WHERE user_id = :uid ORDER BY id DESC');
            $this->db->bind(':uid', $_SESSION['rexkod_user_id']);
            $temp = $this->db->single();

            $this->db->query('SELECT * FROM cart WHERE created_by =:created_by');
            $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
            $x = $this->db->resultSet();

            foreach ($x as $k) 
            {
                $s = '';
                $this->db->query('INSERT INTO product_order_list(item_id, item_name, item_qty, item_price, item_total_price, created_by, p_id,p_img) VALUES (:id,:name,:qty,:price,:total,:created_by,:p_id,:p_img)');
                $this->db->bind(':id', $k->item_id);
                $this->db->bind(':name', $k->item_name);
                $this->db->bind(':qty', $k->item_qty);
                $this->db->bind(':price', $k->item_price);
                $this->db->bind(':total', $k->item_total_price);
                $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
                $this->db->bind(':p_id', $temp->id);
                $this->db->bind(':p_img', $k->img);

                $xq = $this->db->execute();
            }

            $this->db->query("DELETE FROM cart WHERE created_by=:created_by");
            $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);

            return($this->db->execute());
        
        } else {
            die("Something Went Wrong");
        }
    }


    public function add_item_to_wishlist_db($data)
    {
        $this->db->query('SELECT * FROM wishlist WHERE item_id = :id');
        $this->db->bind(':id', $data['id']);
        $x = $this->db->single();
        $x1 = 0;
        $qt = 0;
        if ($x) 
        {
            $qt = (int)$data['qty'] + (int)$x->item_qty;
            $x1 = (float)$data['total'] + (float)$x->item_total_price;

            $this->db->query('UPDATE wishlist SET item_qty=:qty, item_total_price=:total WHERE id=:id');

            $this->db->bind(':id', $x->id);
            $this->db->bind(':qty', $qt);
            $this->db->bind(':total', $x1);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->query('INSERT INTO wishlist(item_id, item_name, item_qty, item_price, item_total_price, created_by,img) VALUES (:id,:name,:qty,:price,:total,:created_by,:img)');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':qty', $data['qty']);
            $this->db->bind(':price', $data['price']);
            $this->db->bind(':total', $data['total']);
            $this->db->bind(':created_by', $data['created_by']);
            $this->db->bind(':img', $data['img']);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getwishlist_items()
    {
        $this->db->query('SELECT * FROM wishlist WHERE created_by=:created_by');
        $this->db->bind(':created_by', $_SESSION['rexkod_user_id']);
        return $this->db->resultSet();
    }



    public function add_banner_db($ban_filename,$ban_pos)
    {
        $this->db->query('UPDATE banner SET '.$ban_pos.'=:ban_filename');
        // Bind values
        $this->db->bind(':ban_filename', $ban_filename);
        
        // Execute

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_banner()
    {
        $this->db->query('SELECT * FROM banner order by id DESC limit 1');

        return $results = $this->db->single();
    }

     public function get_all_vendors(){
        $this->db->query("SELECT * FROM vendors");
  
        $results = $this->db->resultset();
  
        return $results;
      }
 

      public function getpropage_points(){
        $this->db->query("SELECT * FROM pro_page_points");
  
        $results = $this->db->resultset();
  
        return $results;
      }



    public function get_all_vendors1()
    {
        $this->db->query('SELECT * FROM vendors');
        
        return $this->db->resultSet();
    }

    public function get_all_products_forVendor($id) 
    {
        $this->db->query('SELECT * FROM products where created_byId = :created_byId');

        $this->db->bind(':created_byId', $id);

        $result = $this->db->resultSet();
        return $result;
    }

    public function get_productsBySearch($search_input)
    {
        $this->db->query('SELECT * FROM products WHERE p_name LIKE concat("%", :search_input, "%")');

        $this->db->bind(':search_input', $search_input);

        return $row = $this->db->resultSet();
    }

    public function get_productById($id)
    {
        $this->db->query('SELECT * FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
        
    }


    public function get_orders_user($user_id) 
    {
        $this->db->query('SELECT * FROM orders where user_id = :user_id ORDER BY id DESC');

        $this->db->bind(':user_id', $user_id);

        $result = $this->db->resultSet();
        return $result;
    }



    public function get_orders() 
    {
        $this->db->query('SELECT * FROM orders ORDER BY order_id DESC');
        $result = $this->db->resultSet();
        return $result;
    }

    public function get_orders_fromProdList($id) 
    {
        $this->db->query('SELECT * FROM payment where book_id = :book_id');

        $this->db->bind(':book_id', $id);

        $result = $this->db->single();
        return $result;
    }
public function disable_employee($id,$discharge_time){
    $this->db->query('UPDATE users  SET employee_status=:status, discharged_at=:discharged_at where mec_id = :id');
    $this->db->bind(':status','1');
    
    $this->db->bind(':discharged_at',$discharge_time);

    $this->db->bind(':id',$id);
    
    if($this->db->execute())
    {
      return true;
    }
    else
    {
      return false;
    }
}
public function enable_employee($id){
    $this->db->query('UPDATE users  SET employee_status=:status where mec_id = :id');
    $this->db->bind(':status','0');
    $this->db->bind(':id',$id);
    
    if($this->db->execute())
    {
      return true;
    }
    else
    {
      return false;
    }
}


public function upload_users() 
{
    if(isset($_POST['importSubmit'])){
    
        // Allowed mime types
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        
        // Validate whether selected file is a CSV file
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
            
            // If the file is uploaded
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                
                // Open uploaded CSV file with read-only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                
                // Skip the first line
                fgetcsv($csvFile);
                
                // Parse line from CSV file line by line
                while(($line = fgetcsv($csvFile)) !== FALSE){
                    // Get row line
        $item0 = $line[0];  
        $item1 = $line[1];  
        $item2 = $line[2];  
        $item3 = $line[3];  
        $item4 = $line[4];  
        $item5 = $line[5];  
        $item6 = $line[6];  
        $item7 = $line[7];  
        $item8 = $line[8];  
        $item9 = $line[9];  
        $item10 = $line[10];  
        $item11 = $line[11];  
        $item12 = $line[12];  
        $item13 = $line[13];  
        $item14 = $line[14];  
        $item15 = $line[15];  
        $item16 = $line[16];  
        $item17 = $line[17];  
        $item18 = $line[18];  
        $item19 = $line[19];  
        $item20 = $line[20];  
        $item21 = $line[21];  
        $item22 = $line[22];  
        $item23 = $line[23];  
        $item24 = $line[24];  
        $item25 = $line[25];  
        $item26 = $line[26];  
        $item27 = $line[27];  
        $item28 = $line[28];  
        $item29 = $line[29];  
        $item30 = $line[30];  
        $item31 = $line[31];  
        $item32 = $line[32];  
        $item33 = $line[33];  
        $item34 = $line[34];  
        $item35 = $line[35];  
        $item36 = $line[36];  
        $item37 = $line[37];  
        $item38 = $line[38];  
        $item39 = $line[39];  
        $item40 = $line[40];  
        $item41 = $line[41];  
        $item42 = $line[42];  
        $item43 = $line[43];  
        $item44 = $line[44];  
        $item45 = $line[45];  
        $item46 = $line[46];  
        $item47 = $line[47];  
        
                   
                        // Insert member line in the linebase
                        $this->db->query("INSERT into users(mec_id, employee_name, employment_type, qualification, department, designation, status, gender, date_of_birth, date_of_joining, emergency_phone_number, person_to_be_contacted, relation, scheduled_confirmation_date, final_confirmation_date, contract_end_date, notice_number_of_days, date_of_retirement, reports_to, grade, branch, leave_policy, attendance_device_id, holiday_list, default_shift, leave_approver, salary_mode, bank_name, bank_ac_no, ifsc_code, health_insurance_provider, health_insurance_no, cell_number, company_email, personal_email, permanent_address, current_address, passport_number, date_of_issue, valid_upto, marital_status, blood_group, resignation_letter_date, relieving_date, reason_for_leaving, leave_encashed, encashment_date, reason_for_resignation) values('$item0', '$item1', '$item2', '$item3', '$item4', '$item5', '$item6', '$item7', '$item8', '$item9', '$item10', '$item11', '$item12', '$item13', '$item14', '$item15', '$item16', '$item17', '$item18', '$item19', '$item20', '$item21', '$item22', '$item23', '$item24', '$item25', '$item26', '$item27', '$item28', '$item29', '$item30', '$item31', '$item32', '$item33', '$item34', '$item35', '$item36', '$item37', '$item38', '$item39', '$item40', '$item41', '$item42', '$item43', '$item44', '$item45', '$item46', '$item47')");
                         
                        $this->db->execute();
                    
                }
                
                
                fclose($csvFile);
                
               
            }
            return true;
        }else{
            return false;
        }
    }
}

    















}
