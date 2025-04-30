<?php
class Admin extends Controller 
{
	public function __construct()
	{
	    $this->pageModel = $this->model('Page'); 
	}

	public function index() 
	{
	   $this->view('admin/index');
        
	}

    public function add_restaurant() 
	{
	   $this->view('admin/add_restaurant');
        
	}

    public function orders()
	{
        $orders = $this->pageModel->get_orders_all(); 
        
        $data = [
                    'orders' => $orders,
                ];   

	   $this->view('admin/orders',$data);
        
	}

    

    public function reports() 
	{
	   $this->view('admin/reports');
        
	}


    public function roles() 
	{
	   $this->view('admin/roles');
        
	}

   

    public function transactions() 
	{
	   $this->view('admin/transactions');
        
	}

    public function users()
	{
        $get_customers = $this->adminModel->get_all_customers();
        $data = [
            'customers' =>$get_customers
        ]; 

	   $this->view('admin/users',$data);
        
	}


    public function view_product($id)
    {

        $products = $this->pageModel->get_single_products($id);

        $data = [
                    'get_pro' => $products,
                ];
        $this->view('admin/view_product',$data);
    }







    public function admin_login()
    {
       
        if(!isset($_POST['username']))
        {
            
            $this->view('admin/admin_login');
        }
        else
        { 
            
            if(!isset($_POST['password']))
            {
                $_SESSION['success'] = "Enter Password";
                $this->view('admin/admin_login');
            }
            else
            {
                $user = "";

                if ( is_numeric($_POST['username']) ) {
                    $email_verify_phone = $this->pageModel->email_verify_phone($_POST['username']);
                } else {
                    $check_email = $this->pageModel->email_verify($_POST['username']);
                }
                

                if(empty($check_email) && empty($email_verify_phone))
                {
                    $_SESSION['success'] = "Invalid Username";
                    $this->view('admin/admin_login');
                }
                else
                {
                    if(!empty($check_email))
                    {
                        $user_results  = $check_email;

                        $password_res = $check_email->password;
                    }
                    elseif(!empty($email_verify_phone))
                    {
                        $user_results  = $email_verify_phone;

                        $password_res = $email_verify_phone->password;
                    }


                    if(password_verify($_POST['password'], $password_res))
                    {
                        $user = $user_results;
                    }
                    else
                    {
                         $user = "";
                    }
                    if(empty($user))
                    {

                       $_SESSION['success'] = "Invalid Credential!";
                       $this->view('admin/admin_login');
                       
                    }else
                    {
                        if($user->type=="admin")
                        {
                            $_SESSION['rexkod_admin_id'] = $user->id;
                            $_SESSION['rexkod_admin_email'] = $user->email;
                            $_SESSION['rexkod_admin_phone'] = $user->phone;
                            $_SESSION['rexkod_login_type'] = $user->type;
                            redirect('admin/index');
                        }

                        elseif($user->type=="vendor")
                        {
                            $_SESSION['rexkod_vendor_id'] = $user->id;
                            $_SESSION['rexkod_vendor_email'] = $user->email;
                            $_SESSION['rexkod_vendor_phone'] = $user->phone;
                            $_SESSION['rexkod_login_type'] = $user->type;
                            redirect('pages/index');
                        }

                        elseif($user->type=="delivery")
                        {
                            $_SESSION['success'] = "You do not have access!";
                            redirect('admin/admin_login');
                            
                        }
                        else
                        {
                            
                            $_SESSION['success'] = "You do not have access!";
                            redirect('admin/admin_login');
                        }
                    }
                    
                }
               
            }
        }
    }



    


 
    


	public function add_product()
    {
        $get_all_subcategory = $this->adminModel->get_all_subcategory();

        $data = [
                    'all_subcategory' => $get_all_subcategory,
        ];
        

        $this->view('admin/add_product', $data);
    }
    




    public function create_product()
    {
        
        $name = $_POST['name'];
        $subcat = $_POST['subcat'];
        // $price = $_POST['price'];
        
        $p_details = $_POST['p_details'];

        if(isset($_SESSION['rexkod_admin_id'])){
            $created_byId = $_SESSION['rexkod_admin_id'];
        }else {
            $created_byId = $_SESSION['rexkod_vendor_id'];
        }

        $min1 = $_POST['min1'];
        $max1 = $_POST['max1'];
        $price1 = $_POST['price1'];

        $min2 = $_POST['min2'];
        $max2 = $_POST['max2'];
        $price2 = $_POST['price2'];

        $min3 = $_POST['min3'];
        $max3 = $_POST['max3'];
        $price3 = $_POST['price3'];

        $min4 = $_POST['min4'];
        $max4 = $_POST['max4'];
        $price4 = $_POST['price4'];


        $min5 = $_POST['min5'];
        $max5 = $_POST['max5'];
        $price5 = $_POST['price5'];

        $data = [
            'min1' => $min1,
            'max1' => $max1,
            'price1' => $price1,
            'min2' => $min2,
            'max2' => $max2,
            'price2' => $price2,
            'min3' => $min3,
            'max3' => $max3,
            'price3' => $price3,
            'min4' => $min4,
            'max4' => $max4,
            'price4' => $price4,
            'min5' => $min5,
            'max5' => $max5,
            'price5' => $price5,
        ];
        $result = $this->adminModel->create_product_db($name, $subcat, $p_details, $created_byId, $data);


        if($result)
        {
            $_SESSION['success'] = "product added successfully..!";
            redirect('admin/index');
        }else
        {
             $_SESSION['success'] = "try later..!";
            redirect('admin/index');
        }
    }





    



    public function all_products()
    {

        $products = $this->pageModel->get_all_products();
        $data = [
                    'all_pro' => $products,
                ];

        $this->view('admin/all_products',$data);
    }

    public function all_cat_subcat()
    {

        $get_all_category = $this->adminModel->get_all_category();
        $get_all_subcategory = $this->adminModel->get_all_subcategory();

        $data = [
            'all_category' => $get_all_category,
            'all_subcategory' => $get_all_subcategory,
        ];

        $this->view('admin/all_cat_subcat',$data);
    }


    


    public function del_product($id)
    {
        $this->pageModel->delete_product($id);
        $_SESSION['success'] = "product deleted successfully";
        redirect('admin/all_products');
    }


    public function update_cod_customer($id)
    { 
        if(isset($_POST['cod'])){
            $cod_val='1';
        }else {
            $cod_val='0';
        }
        
        $codupdate = $this->adminModel->update_cod_customer($id,$cod_val);

        
        if($codupdate){
        $_SESSION['success'] = "COD Updated";
        redirect('admin/customers_cod');
        } else {
            
            $_SESSION['success'] = "COD Not Updated";
            redirect('admin/customers_cod');
    
            }
    }


    public function update_cod_vendor($id)
    { 
        if(isset($_POST['cod'])){
            $cod_val='1';
        }else {
            $cod_val='0';
        }
        
        $codupdate = $this->adminModel->update_cod_vendor($id,$cod_val);

        
        if($codupdate){
        $_SESSION['success'] = "COD Updated";
        redirect('admin/vendors_cod');
        } else {
            
            $_SESSION['success'] = "COD Not Updated";
            redirect('admin/vendors_cod');
    
            }
    }
    






    public function change_pass()
    {
        $this->view('admin/change_pass');
    }

 



    public function add_coupon_vendor()
    {
        $get_all_vendors = $this->pageModel->get_all_vendors();
        

        $data = [
                    'all_vendors' => $get_all_vendors
        ];

        $this->view('admin/add_coupon_vendor',$data);
    }


    public function add_coupon_subcat()
    {
        $get_all_subcategory = $this->adminModel->get_all_subcategory();

        $data = [
            'all_subcategory' => $get_all_subcategory,
        ];

        $this->view('admin/add_coupon_subcat',$data);
    }



    public function change_password()
    {
        if(isset($_POST['opass']))
        {
            $opass = $_POST['opass'];
            $r = $this->pageModel->check_pass($opass);

            if($r == true)
            {
                if(isset($_POST['npass']))
                {
                    if(isset($_POST['cpass']))
                    {
                        if($_POST['npass'] == $_POST['cpass'])
                        {
                            if(empty($_POST['user_email']))
                            {
                                $email = $r->email;
                            }
                            else
                            {
                                $email = $_POST['user_email'];
                            }

                            $this->pageModel->update_password($_POST['npass'], $email);

                            $_SESSION['success'] = "Password Changed successfully..!";
                            redirect('admin/change_pass');
                        }
                        else
                        {
                            $_SESSION['success'] = "Confirm Password not matching with New Password";
                            redirect('admin/change_pass');
                        }
                    }
                    else
                    {
                        $_SESSION['success'] = "Enter Confirm Password";
                        redirect('admin/change_pass');
                    }
                }
                else
                {
                    $_SESSION['success'] = "Enter New Password";
                    redirect('admin/change_pass');
                }
            }
            else
            {
              $_SESSION['success'] = "current password not matching";
              redirect('admin/change_pass');
            }
        }
        else
        {
          $_SESSION['success'] = "Enter current Password";
          redirect('admin/change_pass');
        }
    }

    public function logout()
    {
       session_destroy();
       redirect('pages/login');
    }

    public function login()
    {
        $this->view('admin/login');
    }
    
    public function orders2()
    {
        $products = $this->adminModel->get_all_orders();
        $data = [
                    'all_orders' => $products,
                ];
        $this->view('admin/orders',$data);
    }


    public function returns()
    {
        $products = $this->adminModel->get_all_orders();
        $data = [
                    'all_orders' => $products,
                ];
        $this->view('admin/returns',$data);
    }



    public function label_orders()
    {
        $products = $this->adminModel->get_all_orders();
        $data = [
                    'all_orders' => $products,
                ];
        $this->view('admin/label_orders',$data);
    }


     public function order_invoice1($id)
    {
        $p_details = $this->adminModel->get_all_userinfo();
        $all_lab = $this->adminModel->find_all_order();

        $get_order_details = $this->adminModel->get_order_details($id);
        $all_order = $this->adminModel->get_pharmacy_med_list($id);
        $get_invoice_details = $this->adminModel->get_pharmacy_med_list_single($id);

        $data = [ 
            // 'p_details' => $p_details,
            // 'all_lab' => $all_lab,
            'sa' => 'n_book',
            'get_order_details' =>  $get_order_details,
            'get_invoice_details' => $get_invoice_details,
            'sa' => 'p_book',
            'id' => $id,
            'all_order' => $all_order,
        ];
        
        $this->view('admin/order_invoice1', $data);
    }


    public function change_state($id)
    {
        // echo 111;
        $st  = $_POST['st'];
        $this->adminModel->change_status($id,$st);
        $_SESSION['success'] = "Status changed";
        redirect('admin/all_orders');
    }


    public function view_order($id)
    {
        $get_order = $this->pageModel->getOrderById($id);
        
        $get_order_detail = $this->pageModel->getOrderDetailById($id);
        
        $data = [
                    'get_order' => $get_order,
                    'get_order_detail' => $get_order_detail
                ];
                
       $this->view('admin/view_order',$data); 
    } 

    
    public function transactions2()
    {
        $products = $this->adminModel->get_all_orders();
        $data = [
                    'all_orders' => $products,
                ];
        $this->view('admin/transactions',$data);
    }

    public function reports2()
    {
       $this->view('admin/reports'); 
    }

    public function vendor_verify($id)
    {
        $verified = $this->adminModel->verify_vendor($id);

        if($verified){
        $_SESSION['success'] = "Vendor Verified!";
        redirect('admin/view_vendor/'.$id);
        }else {
        $_SESSION['success'] = "Vendor Not Verified!";
        redirect('admin/view_vendor/'.$id);
        }

    }


    public function customer_verify($id)
    {
        $verified = $this->adminModel->verify_customer($id);

        if($verified){
        $_SESSION['success'] = "Customer Verified!";
        redirect('admin/view_customer/'.$id);
        }else {
        $_SESSION['success'] = "Customer Not Verified!";
        redirect('admin/view_customer/'.$id);
        }

    }





    public function vendors()
    {

        $get_all_vendors = $this->pageModel->get_all_vendors();
        

        $data = [
                    'all_vendors' => $get_all_vendors
        ];
        
        

       $this->view('admin/vendors',$data); 
    }


    public function vendors_cod()
    {

        $get_all_vendors = $this->pageModel->get_all_vendors();
        

        $data = [
                    'all_vendors' => $get_all_vendors
        ];
        
        

       $this->view('admin/vendors_cod',$data); 
    }




    public function view_vendor($id)
    {
        $get_user = $this->pageModel->get_userinfo($id);
        $get_vendor = $this->pageModel->getVendorById($id);
        

        $data = [
                    'user_detail' => $get_user,
                    'vendor_detail' => $get_vendor,
        ];
        
        $this->view('admin/view_vendor',$data); 
    }


    public function view_customer($id)
    {
        $get_user = $this->pageModel->get_userinfo($id);
        $get_customer = $this->pageModel->get_custinfo($id);
        

        $data = [
            'user_detail' => $get_user,
            'customer_detail' => $get_customer
        ];
        
        $this->view('admin/view_customer',$data); 
    }



    public function profile()
    {
        $id = $_SESSION['rexkod_vendor_id'];
        $get_user = $this->pageModel->get_userinfo($id);
        $get_vendor = $this->pageModel->getVendorById($id);
        

        $data = [
                    'user_detail' => $get_user,
                    'vendor_detail' => $get_vendor,
        ];
        $this->view('admin/profile',$data); 
    }



    public function admin_register()
    {
       $this->view('admin/admin_register'); 
    }




    public function add_vendor(){


        


            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
            {


                $name = $_POST['admin_name'];
                $rname = $_POST['vendor_name'];
                $email = $_POST['vendor_email'];
                $phone = $_POST['vendor_phone'];
                $pass = $_POST['vendor_phone'];
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $address = $_POST['vendor_address'];
                $latlong = $_POST['vendor_latlong'];
                $gst = $_POST['vendor_gst'];
                $fssai = $_POST['vendor_fssai'];
                $start_time = $_POST['vendor_start_time'];
                $end_time = $_POST['vendor_end_time'];
                $bank_number = $_POST['vendor_bank_number'];
                $bank_ifsc = $_POST['vendor_bank_ifsc'];
     
                if (empty($email)) 
            {
                $_SESSION['success'] = 'Please enter email';
                $this->view('admin/add_vendor'); 
            } else if ($this->pageModel->findUserByemail($email)) 
            {
              $_SESSION['success'] = 'Email already taken';
              $this->view('admin/add_vendor'); 
            } 
            else 
            {
    
    
                    if ($this->pageModel->email_verify_phone($phone)) 
                    {
                      $_SESSION['success'] = 'Phone number already taken';
                      redirect('admin/add_vendor'); 
                    } 
                    else 
                    {

                        

                    if(!empty($_FILES['vendor_image']['name']))
                     {
                    $f_name = $_FILES['vendor_image']['name'];
                    $f_temp = $_FILES['vendor_image']['tmp_name'];
                    $size = $_FILES['vendor_image']['size'];
                    $f_extension=explode('.', $f_name);
                    $f_extension=strtolower(end($f_extension));
                    $unqdate = date("Ymd");
                    $unqtime = time();
                    $unqname = $unqdate."".$unqtime;
                    $f_newfile=$unqname.'.' .$f_extension;
                    $store="uploads/" .$f_newfile;
                    move_uploaded_file($f_temp, $store);
                    $store ="uploads/";
                    $img=$f_newfile;
                     }
                     else
                        {
                        $img = "vendor.png";
                    }
    

                        if ($this->pageModel->add_vendor($name, $rname, $img, $email, $phone, $pass, $address, $latlong, $gst, $fssai, $start_time, $end_time, $bank_number, $bank_ifsc)) 
                        {
                            $_SESSION['success'] = "Registered Successfully..! ";
                            $this->view('admin/add_vendor'); 
                        }
                        else
                        {
                            $_SESSION['success'] = 'Registeration Failed';
                            $this->view('admin/add_vendor'); 
                        }
                    }
                }
            } 
            else 
            {
                $this->view('admin/add_vendor'); 
            }
        }



        
    public function add_profile(){

        $get_all_subcategory = $this->adminModel->get_all_subcategory();

        $data = [
            'all_subcategory' => $get_all_subcategory,
        ];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
            {

                
                $name = $_POST['name'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $pincode = $_POST['pincode'];
                $gst = $_POST['gst'];
                $timing = $_POST['timing'];
                $minval = $_POST['minval'];
                $subcat_id = $_POST['subcat_id'];
     
                
                        if ($this->pageModel->add_vendor_profile($name, $address, $city, $state, $pincode, $gst, $timing, $minval, $subcat_id)) 
                        {
                            $_SESSION['success'] = "Profile Added Successfully..! ";
                            redirect('admin/profile'); 
                        }
                        else
                        {
                            $_SESSION['success'] = 'Profile Not Added';
                            $this->view('admin/add_profile'); 
                        }
             }
            else 
            {
                $this->view('admin/add_profile',$data); 
            }
        }



        
        public function settings()
        {
           $this->view('admin/settings'); 
        }

        public function shipping_subcat()
        {
            $get_all_subcategory = $this->adminModel->get_all_subcategory();

            $data = [
                        'all_subcategory' => $get_all_subcategory,
            ];
            $this->view('admin/shipping_subcat', $data); 
        }

        public function shipping_range()
        {
           $this->view('admin/shipping_range'); 
        }

        public function tcs_certificate_vendor()
        {
           $this->view('admin/tcs_certificate_vendor'); 
        }

        public function tcs_certificate_customer()
        {
           $this->view('admin/tcs_certificate_customer'); 
        }
 

    public function add_user()
    {
       $this->view('admin/add_user'); 
    }

    public function payout()
    {
       $this->view('admin/payout'); 
    }

    public function invoice()
    {
       $this->view('admin/invoice'); 
    }

    public function create_user()
    {

        $pass = $_POST['password'];

        $pass1 = password_hash($pass, PASSWORD_DEFAULT);

        $data = [ 

            'name' =>  $_POST['name'],
            'email' =>  $_POST['email'],
            'ph_no' =>  $_POST['ph_no'],
            'address' =>  $_POST['address'],
            'pin_code' =>  $_POST['pin_code'],
            'password' =>  $pass1,            
        ];

        $insert_auth_deliveryUser = $this->adminModel->insert_auth_deliveryUser($data);

        $_SESSION['success'] = "Delivery user Created Successfully";
        redirect('admin/all_deliveryUsers');
    }

    public function all_deliveryUsers()
    {
        $get_all_deliveryUsers = $this->adminModel->get_all_deliveryUsers();

        $data = [ 
            
            'get_all_deliveryUsers' => $get_all_deliveryUsers,
        ];

       $this->view('admin/all_deliveryUsers', $data); 
    }

    public function edit_deliveryUser($id)
    {

        $get_all_by_ID = $this->adminModel->get_all_by_ID($id);

         $data = [ 
            
            'get_all_by_ID' => $get_all_by_ID,
        ];

       $this->view('admin/edit_deliveryUser', $data);

    }

    public function update_user()
    {
        if(empty($_POST['password']))
        {

            $data = [ 

                'auth_id' =>  $_POST['auth_id'],
                'name' =>  $_POST['name'],
                'email' =>  $_POST['email'],
                'ph_no' =>  $_POST['ph_no'],
                'address' =>  $_POST['address'],
                'pin_code' =>  $_POST['pin_code'],            
            ];

            $update_auth_deliveryUser = $this->adminModel->update_auth_deliveryUser($data);

            $_SESSION['success'] = "Delivery user Updated Successfully";
            redirect('admin/all_deliveryUsers');

        }
        else
        {
            $pass = $_POST['password'];

            $pass1 = password_hash($pass, PASSWORD_DEFAULT);
     
            
            $data = [ 

                'auth_id' =>  $_POST['auth_id'],
                'name' =>  $_POST['name'],
                'email' =>  $_POST['email'],
                'ph_no' =>  $_POST['ph_no'],
                'address' =>  $_POST['address'],
                'pin_code' =>  $_POST['pin_code'],  
                'password' =>  $pass1,          
            ];

            $update_auth_deliveryUser = $this->adminModel->update_auth_deliveryUser1($data);

            $_SESSION['success'] = "Delivery user Updated Successfully";
            redirect('admin/all_deliveryUsers');

        }

        
    }

    public function delete_deliveryUser($id)
    {

       $delete_deliveryUserby_id = $this->adminModel->delete_deliveryUserby_id($id);
       
       $_SESSION['success'] = "Delivery user deleted Successfully";
            redirect('admin/all_deliveryUsers'); 

    }

    public function assign_orders()
    {
        $get_all_deliveryUsers = $this->adminModel->get_all_deliveryUsers();

        $products = $this->adminModel->get_all_orders();
       
        $data = [
                    'all_pro' => $products,
                    'get_all_deliveryUsers' => $get_all_deliveryUsers,
                ];
 
        $this->view('admin/assign_orders',$data);

    }

    public function assign_deliveryUser($id)
    {

        $get_all_by_ID = $this->adminModel->get_all_by_ID($_POST['delivery_user']);

        $this->adminModel->change_deliverystatus($id,$get_all_by_ID->auth_id, $get_all_by_ID->name);

        $_SESSION['success'] = "Delivery User Assigned Successfully";
        redirect('admin/assign_orders');

    }

  




    public function add_category()
    {
        $this->view('admin/add_category');
    }


    public function add_subcategory()
    {
        $get_all_category = $this->adminModel->get_all_category();

        $data = [
            'all_category' => $get_all_category,
        ];

        $this->view('admin/add_subcategory', $data);
    }


    public function create_category()
    {
        $category_name = $_POST['category_name'];

        $this->adminModel->create_category($category_name);

        $_SESSION['success'] = "Category created Successfully";
        redirect('admin/index'); 
    }


    public function create_coupon()
    {
        $coupon_title = $_POST['coupon_title'];
        $coupon_vendor = $_POST['coupon_vendor'];
        if(!isset($coupon_vendor)){$coupon_vendor = 0;}
        $coupon_subcat = $_POST['coupon_subcat'];
        if(!isset($coupon_subcat)){$coupon_subcat = 0;}
        $coupon_code = $_POST['coupon_code'];
        $coupon_type = $_POST['coupon_type'];
        $coupon_value = $_POST['coupon_value'];
        $coupon_cap = $_POST['coupon_cap'];

        $coupon_stat = $this->adminModel->create_coupon($coupon_title,$coupon_vendor,$coupon_subcat,$coupon_code,$coupon_type,$coupon_value,$coupon_cap);

        if($coupon_stat){
            $_SESSION['success'] = "Coupon created Successfully";
             redirect('admin/coupons'); }

    else {
        $_SESSION['success'] = "Coupon not created";
             redirect('admin/add_coupon'); }
             
    }
    


    public function create_subcategory()
    {
        $subcategory_name = $_POST['subcategory_name'];
        $category_id = $_POST['category_id'];
        $subcategory_hsn = $_POST['subcategory_hsn'];
        $subcategory_tax = $_POST['subcategory_tax'];
        $shipping_cost = $_POST['shipping_cost'];

        $cursub = $this->adminModel->create_subcategory($subcategory_name,$category_id,$subcategory_hsn,$subcategory_tax,$shipping_cost);

        if($cursub){
        $_SESSION['success'] = "Subcategory created Successfully";
        redirect('admin/subcategory'); 
        } else {
            $_SESSION['success'] = "Subcategory Not Created";
            redirect('admin/add_subcategory'); 
        }
    }



    public function category()
    {

        $get_all_category = $this->adminModel->get_all_category();

        $data = [
                    'all_category' => $get_all_category,
        ];

        $this->view('admin/category',$data);

    }

  


    public function coupons()
    {

        $get_all_coupons = $this->adminModel->get_all_coupons();

        $data = [
                    'all_coupons' => $get_all_coupons,
        ];

        $this->view('admin/coupons',$data);

    }


    public function subcategory()
    {

        $get_all_subcategory = $this->adminModel->get_all_subcategory();

        $data = [
                    'all_subcategory' => $get_all_subcategory,
        ];

        $this->view('admin/subcategory',$data);

    }


    public function payouts()
    {

        $get_payouts = $this->adminModel->get_all_payouts();

        $data = [
                    'all_payouts' => $get_payouts,
        ];

        $this->view('admin/payouts',$data);

    }



    public function edit_category($id)
    {
        $get_categoryBy_id = $this->adminModel->getCategoryById($id);

        $data = [
            'category' => $get_categoryBy_id,
        ];

        $this->view('admin/edit_category',$data);
    }


    public function edit_subcategory($id)
    {
        $get_subcategoryBy_id = $this->adminModel->getSubcategoryById($id);

        $data = [
            'subcategory' => $get_subcategoryBy_id,
        ];

        $this->view('admin/edit_subcategory',$data);
    }




    public function vendor_register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $email = $_POST['email'];
            $phno = $_POST['phno'];
            $pass = $_POST['password'];
 
            if (empty($email)) 
            {
                $_SESSION['success'] = 'Please enter email';
                redirect('admin/admin_register');
            } else if ($this->pageModel->findUserByemail($email)) 
            {
              $_SESSION['success'] = 'Email already taken';
              redirect('admin/admin_register');
            } 
            else 
            {


                if ($this->pageModel->findUserByphno($phno)) 
                {
                  $_SESSION['success'] = 'Phone number already taken';
                  redirect('admin/admin_register');
                } 
                else 
                {

                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    if ($this->adminModel->add_vendor($email, $phno, $pass)) 
                    {
                        
                            $user = $this->pageModel->ulogin($email, $_POST['password']);
                        
                            $_SESSION['rexkod_vendor_id'] = $user->id;
                            $_SESSION['rexkod_vendor_email'] = $user->email;
                            $_SESSION['rexkod_vendor_phone'] = $user->phone;
                            $_SESSION['rexkod_login_type'] = $user->type;

                        $_SESSION['success'] = "Registered Successfully..! ";
                        redirect('admin/add_profile');
                    }
                    else
                    {
                        $_SESSION['success'] = 'Registration Failed!';
                        redirect('admin/admin_register');
                    }
                }
            }
        } 
        else 
        {
          redirect('admin/admin_register');
        }
    }




    public function update_category()
    {
        $get_categoryBy_id = $this->adminModel->get_categoryBy_id($_POST['id']);

        $update_category = $this->adminModel->update_category($_POST['id'], $_POST['category_name'], $get_categoryBy_id->img);

        $_SESSION['success'] = "Category updated Successfully";
        redirect('admin/all_category'); 

    }

    public function change_status_category($id)
    {
        $id_arr = explode("|", $id);

        if($id_arr[1] == 11)
        {
            $status = 1;
        }
        elseif($id_arr[1] == 22)
        {
            $status = 0;
        }

        $update_status_category = $this->adminModel->update_status_category($id_arr[0], $status);

        $_SESSION['success'] = "Status updated Successfully";
        redirect('admin/all_category'); 
    }

    public function edit_product($id)
    {
        $get_productBy_id = $this->adminModel->get_productBy_id($id);

         $data = [
            'product' => $get_productBy_id,
        ];

        $this->view('admin/edit_product',$data);

    }

    public function update_product()
    {
        $id = $_POST['id'];

        // echo $_POST['category_name'];

        // $get_categoryBy_name = $this->adminModel->get_categoryBy_name($_POST['category_name']);

        // var_dump($get_categoryBy_name);

        $cat = $_POST['cat'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $discount_price = $_POST['discount_price'];
        $p_details = $_POST['p_details'];
        $product_type = $_POST['product_type'];

        $get_productBy_id = $this->adminModel->get_productBy_id($_POST['id']);


        $result = $this->adminModel->update_product_db($id, $name, $price, $discount_price, $cat, $p_details, $product_type, $get_productBy_id->p_image);
        if($result)
        {
            $_SESSION['success'] = "Product Updated successfully..!";
            redirect('admin/all_products');
        }else
        {
             $_SESSION['success'] = "try later..!";
            redirect('admin/all_products');
        }

    }

    public function viewOrder_deliveryUser($user_id)
    {

        $viewOrder_deliveryUser = $this->adminModel->viewOrder_deliveryUser($user_id);

        $get_all_by_ID = $this->adminModel->get_all_by_ID($user_id);

        $data = [
            'viewOrder_deliveryUser' => $viewOrder_deliveryUser,
            'get_all_by_ID' => $get_all_by_ID
        ];

        $this->view('admin/viewOrder_deliveryUser',$data);

    }

    public function viewOrderbyType_deliveryUser($comb_id)
    {
        $comb_arr = explode("|", $comb_id);

        $viewOrder_deliveryUser = $this->adminModel->viewOrder_deliveryUser($comb_arr[1]);

        $get_all_by_ID = $this->adminModel->get_all_by_ID($comb_arr[1]);

        $data = [
            'viewOrder_deliveryUser' => $viewOrder_deliveryUser,
            'get_all_by_ID' => $get_all_by_ID,
            'status' => $comb_arr[0] 
        ];

        $this->view('admin/viewOrderbyType_deliveryUser',$data);

    }

    public function pending_orders()
    {
        $products = $this->adminModel->get_all_orders();

        $data = [
            
            'all_pro' => $products,
        ];
        $this->view('admin/pending_orders',$data);
    }

    public function completed_orders()
    {
        $products = $this->adminModel->get_all_orders();
        
        $data = [
            
            'all_pro' => $products,
        ];
        $this->view('admin/completed_orders',$data);
    }

    public function update_active_status($id)
    {
        $id_arr = explode("|", $id);

        if($id_arr[1] == 1)
        {
            $update_active_status_db = $this->adminModel->update_active_status_db($id_arr[0], 1);

            $_SESSION['success'] = "Delivery User Activated successfully";    

            redirect('admin/all_deliveryUsers');

        }
        elseif($id_arr[1] == 0)
        {
            $update_active_status_db = $this->adminModel->update_active_status_db($id_arr[0], 0);

            $_SESSION['success'] = "Delivery User De-Activated successfully";    

            redirect('admin/all_deliveryUsers');
        }
    }

    public function product_ratings()
    {

        $products = $this->pageModel->get_all_products();
        $data = [
                    'all_pro' => $products,
                ];
        $this->view('admin/product_ratings',$data);
    }

    public function qr_code()
    {
         $res = $this->pageModel->ulogin_using_rowId($_SESSION['user_id']);

        $data = [
            'res' => $res
        ];

        $this->view('admin/qr_code', $data);
    }

    public function create_QR()
    {
        if(!empty($_FILES['files_display']['name']))
        {
            $f_name = $_FILES['files_display']['name'];
            $f_temp = $_FILES['files_display']['tmp_name'];
            $size = $_FILES['files_display']['size'];
            $f_extension=explode('.', $f_name);
            $f_extension=strtolower(end($f_extension));
            $f_newfile=uniqid().'.' .$f_extension;
            $store="uploads/" .$f_newfile;
            move_uploaded_file($f_temp, $store);
            $store ="uploads/";
            $_SESSION['attachment']=$f_newfile;
        }
        else
        {
            $_SESSION['attachment']="demo.png";
        }

        $products = $this->pageModel->change_QR($_SESSION['attachment']);

        $_SESSION['success'] = "QR code uploaded successfully";    

            redirect('admin/qr_code');
    }


    public function view_orderDetails($id)
    {

        $get_order_details = $this->adminModel->get_order_details($id);

        $data = [ 
                    
            'get_order_details' =>  $get_order_details,            
        ];

        $this->view('admin/view_orderDetails', $data);
    }

    public function view_allProdByCat($id)
    {

         $view_allProdByCat = $this->adminModel->view_allProdByCat($id);

        $data = [ 
                    
            'all_pro' =>  $view_allProdByCat,            
        ];

        $this->view('admin/view_allProdByCat', $data);


    }


     public function download_excel() {




        $productResult=$this->adminModel->get_download_content();

        

          $this->exportProductDatabase($productResult);


    }



    public function customers()
    {         
        $get_all_customers = $this->adminModel->get_all_customers();

        $data = [

            'all_customers' => $get_all_customers,
        ];

        $this->view('admin/customers',$data); 
    }


    public function customers_cod()
    {         
        $get_all_customers = $this->adminModel->get_all_customers();

        $data = [

            'all_customers' => $get_all_customers,
        ];

        $this->view('admin/customers_cod',$data); 
    }



       

      public function exportProductDatabase($productResult) {
      
        $timestamp = time();
        $filename = 'Export_excel_' . $timestamp . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader = false;

        foreach ($productResult as $file) {
                        $result = [];
                        array_walk_recursive($file, function($item) use (&$result) {
                        $result[] = $item;
                        });
                     // fputcsv($output, $result);
                 


        // foreach ($productResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($result)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($result)) . "\n";


         }
        exit();

    }

    public function banner()
    {
        $get_banner = $this->pageModel->get_banner();

        $data = [

            'get_banner' => $get_banner
        ];   

        $this->view('admin/banner', $data);
    }



    public function create_banner()
    {

        if(!empty($_FILES['ban_file']['name']))
        {
            $f_name = $_FILES['ban_file']['name'];
            $f_temp = $_FILES['ban_file']['tmp_name'];
            $size = $_FILES['ban_file']['size'];
            $f_extension=explode('.', $f_name);
            $f_extension=strtolower(end($f_extension));
            $f_newfile=uniqid().'.' .$f_extension;
            $store="uploads/" .$f_newfile;
            move_uploaded_file($f_temp, $store);
            $store ="uploads/";
            $ban_filename=$f_newfile;
            $ban_pos = $_POST['ban_pos'];
            

            switch ($ban_pos) {
                case "Banner 1":
                  $ban_pos="ban1";
                  break;
                case "Banner 2":
                  $ban_pos="ban2";
                  break;
                case "Banner 3":
                  $ban_pos="ban3";
                  break;
                case "Banner 4":
                  $ban_pos="ban4";
                  break;
                case "Banner 5":
                  $ban_pos="ban5";
                  break;
                case "Deal 1":
                  $ban_pos="deal1";
                  break;
                case "Deal 2":
                   $ban_pos="deal2";
                    break;
                case "Deal 3":
                    $ban_pos="deal3";
                    break;
            
              }


            
            $result = $this->pageModel->add_banner_db($ban_filename,$ban_pos);
        }

        
        if($result){
            $_SESSION['success'] = "Banner Updated Successfully";
            redirect('admin/banner');
        } else {
            $_SESSION['success'] = "Banner Not Updated";
            redirect('admin/banner');
        }
       

    }





}