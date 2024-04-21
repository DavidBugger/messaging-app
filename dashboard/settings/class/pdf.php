<?php
require_once('MyPdf.php');
class Pdf extends MyPdf
{
    public $db;
    public $conn;
    public $path;
    // public $controller;
    public function __construct()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == 'localhost' or $ip == '::1') :
            $this->path = 'http://localhost/messaging/';
        else :
            $this->path = $_SERVER['SERVER_NAME'] . '/';
        endif;

        $this->db = new Connection(); //call the database class
        $this->conn = $this->db->connect(); //call the database connection function

        // $this->controller = new Controller();
    }

    public function generateInvoice($data)
    {
        
        $pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_CREATOR);
        $pdf->SetTitle(PDF_CREATOR);
        $pdf->SetSubject(PDF_CREATOR);

        // set default header data
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '../pdf/lang/eng.php')) {
            require_once(dirname(__FILE__) . '../pdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set style for barcode
        $style = array(
            'border' => true,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        // set font
        $pdf->SetFont('times', '', 12);

        $stmt = $this->conn->prepare("
            SELECT u.password,u.user_id,u.firstname,u.lastname, u.mobile_phone,u.email,u.sex,u.role_id,u.role_name,u.status 
            FROM userdata AS u  WHERE u.user_id='".$data['user_id']."'
        ");
        $stmt->execute();
        $row = $stmt->fetch();

        if ($stmt->rowCount() > 0) :
            $sub_id = str_replace('/', '-', $data['user_id']) . '-' . date('dmY') . '-' . date('his');
            $expires_on = date('d-m-Y h:i:s a', strtotime('+ 1 month'));
            $pid = $data['pid'];
            $stmt = $this->conn->prepare("
                INSERT INTO 
                subscription (user_id, subscription_id, plan_id ,expires_on,  payment_status ) 
                VALUES( '$data', '$sub_id', '$pid' ,'$expires_on', '0')
            ");

            $get_plan = $this->conn->prepare("SELECT plan_name, plan_price, plan_id FROM membership_plans WHERE plan_id = '$pid'");
            $get_plan->execute();

            $plan = $get_plan->fetch();

            $plan_name = $plan['plan_name'];
            $plan_price = $plan['plan_price'];

            $stmt->execute();

            if ($stmt) :
                $pdf->AddPage();

                $name = $row['firstname'] . ' ' . $row['lastname'];

                $pdf->SetFont('times', 'B', 18);
                $pdf->write2DBarcode($sub_id, 'QRCODE,L', 20, 30, 20, 20, $style, 'N');

                $pdf->Ln(10);
                $pdf->SetFont('times', 'B', 15);
                $pdf->Cell(0, 25, 'Service Breakdown', 0, false, 'C', 0, '', 0, false, 'M', 'M');;

                $pdf->Ln(10);
                $pdf->SetFont('times', 'B', 12);
                $pdf->Cell(360, 0, "Customer's Name: " . $name, 0, 0, 'L');

                $pdf->Ln(10);
                $pdf->Cell(360, 0, 'Membership Id: ' . $row['user_id'], 5, 0, 'L');

                $pdf->Ln(10);
                $pdf->Cell(360, 0, 'Membership Plan: ' . $plan_name, 5, 0, 'L');

                $pdf->Ln(10);
                $pdf->Cell(360, 0, 'Invoice No: ' . $sub_id, 5, 0, 'L');

                $img_file = 'assets/images/10.png';
                // $pdf->Image($img_file,0,0,20,30,'','','',false,300,'',false,false,0);
                $pdf->Ln(10);
                $html = '<div>
                <p>Please, you are expected to pay the amount specified in this invoice to qualify you as a member.</p>
                <p></p>
                <table cellpadding="5" bgcolor="white" border="1" cellspacing="1" align="left">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Duration</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Membership Fee</td>
                        <td>1 month</td>
                        <td>A$' . number_format($plan_price, 2) . '</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Sub Total</td>
                            <td>1 month</td>
                            <td>A$' . number_format($plan_price, 2) . '</td>
                        </tr>
                        
                        <tr>
                            <td>Service Charge</td>
                            <td></td>
                            <td>A$' . number_format(3, 2) . '</td>
                        </tr>
                        
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td>A$' . number_format($plan_price + 3, 2) . '</td>
                        </tr>
                    </tfoot>
                </table>
                <p></p>
                <p>Note that this subscription is only valid until '.date('F d, Y h:i a', strtotime($expires_on)).'</p>
                <p></p>
                <p>Regards</p>
                </div>';

                $pdf->writeHTML($html, true, false, true, false, '');

                $ip = $_SERVER['REMOTE_ADDR'];

                if ($ip == '::1' || $ip == 'localhost') :
                    $path = $_SERVER['DOCUMENT_ROOT'] . '/new/files/';
                else :
                    $path = $_SERVER['SERVER_NAME'] . 'files/';
                endif;

                $filepath = glob($path . '*'); // get all file names

                if (empty($filepath)) :
                else :
                    foreach ($filepath as $file) : // iterate files
                        if (is_file($file)) :
                            unlink($file); // delete all files from the specigied directory
                        endif;
                    endforeach;
                endif;

                if (!file_exists($path)) {
                    mkdir($path);
                }

                //  Clear buffer
                ob_end_clean();

                $filename = str_replace('/', '_', $data) . '_' . date('YmdHis') . '.pdf';
                $pdf->Output($path . $filename, 'F');

                $emailFile = $pdf->Output(str_replace('/','',$data).date('YmdHis').'.pdf','S');
                $mail = new SendMail();

                $message = "
                    <p>Hello <b>" . $row['firstname'] . ",</b></p>
                    <div class='activity-card' style='background: white; margin-top: 10px; border-bottom: 2px solid #24C8A6; text-align: justify; color: grey;'>
                        <p>Once again, you are elcome to Fresh Forever.</p>
                                    
                        <p>Please, attached is a copy of your payment invoice..</p>
                        
                        <p>
                            <i>Best regards!</i>
                        </p>
                    </div>";

                $subject = "Payment Invoice";

                $send = array(
                    'message' => $message,
                    'to' => $email,
                    'subject' => $subject,
                    'attachment' => $emailFile,
                    'filename' => $filename,
                    'extra' => true
                );

                $mail->Send_mail($send);

                return json_encode(array('response_code' => 0, 'response_message' => $filename));
            else :
                return json_encode(array('response_code' => 20, 'response_message' => 'Could not generate invoice'));
            endif;
        else :
            return json_encode(array('response_code' => 20, 'response_message' => 'Invalid credential'));
        endif;
    }
    public function generateOrderInvoice($data)
    {
        
        $pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_CREATOR);
        $pdf->SetTitle(PDF_CREATOR);
        $pdf->SetSubject(PDF_CREATOR);

        // set default header data
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '../pdf/lang/eng.php')) {
            require_once(dirname(__FILE__) . '../pdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set style for barcode
        $style = array(
            'border' => true,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        // set font
        $pdf->SetFont('times', '', 12);

        $stmt = $this->conn->prepare("
            SELECT u.password,u.user_id,u.firstname,u.lastname, u.mobile_phone,u.email,u.sex,u.role_id,u.role_name,u.status 
            FROM userdata AS u  WHERE u.user_id='".$data['user_id']."'
        ");
        
        $stmt->execute();
        $row = $stmt->fetch();

        if ($stmt->rowCount() > 0) :
            $pdf->AddPage('L');

            $stmt = $this->conn->prepare("SELECT delivery_type, payment, status, package_id FROM orders WHERE order_ref='".$data['order_ref']."'");
            $stmt->execute();
            $d_type = $stmt->fetch();

            $name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];

            $pdf->SetFont('times', 'B', 18);
            $pdf->write2DBarcode('Order Reference: '.$data['order_ref'].' Package: '.$d_type['package_id'], 'QRCODE,L', 20, 30, 20, 20, $style, 'N');

            $title = (!empty($data['cart']))?'Order Breakdown':'Invoice ';
            $pdf->Ln(8);
            $pdf->SetFont('times', 'B', 15);
            $pdf->Cell(0, 25, $title, 0, false, 'C', 0, '', 0, false, 'M', 'M');;

            $pdf->Ln(8);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(360, 0, "Customer's Name: " . $name, 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->Cell(360, 0, 'Ref: ' . $data['order_ref'], 5, 0, 'L');

            $pdf->Ln(10);

            $pdf->Cell(360, 0, 'Method of Delivery: ' . $d_type['delivery_type'], 5, 0, 'L');

            $pdf->Ln(5);

            if(isset($data['cart']) && !empty($data['cart'])):

                $html = '<div>
                    <p><b>Payment Account Details</b></p>
                    <p>Account Name: Fresh Forever</p>
                    <p>BSB: 061425</p>
                    <p>Account Number: 19886607</p>
                    <p>Bank Name: Commonwealth Bank</p>
                    <p></p>
                    <table cellpadding="5" bgcolor="white" border="1" cellspacing="1" align="left">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                        $total = 0;
                        $qty = 0;
                        foreach($data['cart'] as $cart):
                            $total += $cart['price'] * $cart['qty'];
                            $qty += $cart['qty'];
                    $html .='
                            <tr>
                                <td><img src="'.$cart['image'].'" style="width: 50px; height: 50px; border-radius:5px"></td>
                                <td>'.$cart['name'].'</td>
                                <td>A$' . number_format($cart['price'], 2) . '</td>
                                <td>' .$cart['qty'] . '</td>
                                <td>A$' . number_format($cart['price'] * $cart['qty'], 2) . '</td>
                            </tr>';
                        endforeach;
                    $html .=' </tbody>
                        <tfoot>
                            <tr>
                                <td>Total(Qty)</td>
                                <td></td>
                                <td></td>
                                <td>' .$qty. '</td>
                                <td>A$' . number_format($total, 2) . '</td>
                            </tr>
                            
                            <tr>
                                <td>Service Charge</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>A$' . number_format(3, 2) . '</td>
                            </tr>
                            
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>A$' . number_format($total + 3, 2) . '</td>
                            </tr>
                        </tfoot>
                </table>
                <p>Please, email your payment receipt to support@freshforever.com.au with your order reference number ('.$data['order_ref'].') as your subject.</p>
                </div>';

            else:
                $stmt = $this->conn->prepare("
                    SELECT o.order_id AS id, o.item_id AS item, o.price, o.qty, o.subtotal, o.user_id AS user, 
                    o.farm_id AS farm, o.order_ref AS ref, o.status, o.payment, o.ordered_date AS date, o.delivered_date AS d_date, 
                    p.item_name AS name, p.item_image AS image, o.package_id AS package FROM orders AS o INNER JOIN product_list AS p 
                    ON p.item_id = o.item_id WHERE o.order_ref='".$data['order_ref']."' ORDER BY o.order_id DESC
                ");
                
                $stmt->execute();
                
                $data_cart = $stmt->fetchAll();

                $status = ($data_cart[0]['status'] == 1)?'<p>Delivered: Yes</p>':'<p>Delivered: No</p>';
                $payment = ($data_cart[0]['payment'] == 1)?'<p>Paid: Yes</p>':'<p>Paid: No</p>';

                $html = '<div>';

                if($data_cart[0]['payment'] != 1):
                $html .= '<p><b>Payment Account Details</b></p>
                    <p>Account Name: Fresh Forever</p>
                    <p>BSB: 061425</p>
                    <p>Account Number: 19886607</p>
                    <p>Bank Name: Commonwealth Bank</p>';
                endif;

                $html .= '<p></p>
                <table cellpadding="5" bgcolor="white" border="1" cellspacing="1" align="left">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                        $total = 0;
                        $qty = 0;
                        foreach($data_cart as $cart):
                            $total += $cart['subtotal'];
                            $qty += $cart['qty'];
                    $html .='
                            <tr>
                                <td><img src="'.$this->path.$cart['image'].'" style="width: 50px; height: 50px; border-radius:5px"></td>
                                <td>'.$cart['name'].'</td>
                                <td>A$' . number_format($cart['price'], 2) . '</td>
                                <td>' .$cart['qty'] . '</td>
                                <td>A$' . number_format($cart['subtotal'], 2) . '</td>
                            </tr>';
                        endforeach;
                    $html .=' </tbody>
                        <tfoot>
                            <tr>
                                <td>Total(Qty)</td>
                                <td></td>
                                <td></td>
                                <td>' .$qty. '</td>
                                <td>A$' . number_format($total, 2) . '</td>
                            </tr>
                            
                            <tr>
                                <td>Service Charge</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>A$' . number_format(3, 2) . '</td>
                            </tr>
                            
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>A$' . number_format($total + 3, 2) . '</td>
                            </tr>
                        </tfoot>
                </table>
                '.$payment.'
                '.$status.'
                </div>';
            endif;

            $pdf->writeHTML($html, true, false, true, false, '');

            $ip = $_SERVER['REMOTE_ADDR'];

            if ($ip == '::1' || $ip == 'localhost') :
                $path = $_SERVER['DOCUMENT_ROOT'] . '/new/files/';
            else :
                $path = $_SERVER['SERVER_NAME'] . 'files/';
            endif;

            $filepath = glob($path . '*'); // get all file names

            if (empty($filepath)) :
            else :
                foreach ($filepath as $file) : // iterate files
                    if (is_file($file)) :
                        unlink($file); // delete all files from the specigied directory
                    endif;
                endforeach;
            endif;

            if (!file_exists($path)) {
                mkdir($path);
            }

            //  Clear buffer
            ob_end_clean();

            $filename = str_replace('/', '_', $data['user_id']) . '_' . date('YmdHis') . '.pdf';
            $pdf->Output($path . $filename, 'F');

            if(isset($data['cart'])):
                $emailFile = $pdf->Output(str_replace('/','',$data['user_id']).date('YmdHis').'.pdf','S');
                $mail = new SendMail();

                $message = "
                    <p>Hello <b>" . $_SESSION['firstname'] . ",</b></p>
                    <div class='activity-card' style='background: white; margin-top: 10px; border-bottom: 2px solid #24C8A6; text-align: justify; color: grey;'>
                        <p>Thank you for shopping with with Fresh Forever.</p>
                                        
                        <p>Please, attached is a copy of your order invoice for payment..</p>
                            
                        <p>
                            <i>Best regards!</i>
                        </p>
                    </div>";

                $subject = "Order Invoice";

                $send = array(
                    'message' => $message,
                    'to' => $email,
                    'subject' => $subject,
                    'attachment' => $emailFile,
                    'filename' => $filename,
                    'extra' => true
                );

                $mail->Send_mail($send);
            endif;

            return json_encode(array('response_code' => 0, 'response_message' => $filename));
        else :
            return json_encode(array('response_code' => 20, 'response_message' => 'Could not generate invoice'));
        endif;
    }

    private function DataColumn($table_name, $where_column, $where_value, $retval)
    {
        $stmt = $this->conn->prepare("SELECT $retval FROM $table_name WHERE $where_column = '$where_value' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        return ($stmt->rowCount() > 0)?$row[$retval]:false;
    }
}
