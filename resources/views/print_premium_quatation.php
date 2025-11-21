<?php
error_reporting(1);
session_start();
include "include/conn.php";
    // get estimate by report no and job no
    $quot_id = base64_decode($_GET["quot_id"]);
    $print_counts = 30;
    //$plused_counts=intval($print_counts)+2;
    $plused_counts = 28;

    $sel_estiamte = "select * from quotation_master where `quot_id`=".$quot_id;
    $result_estiamte = mysqli_query($conn, $sel_estiamte);
    $row_estiamte = mysqli_fetch_array($result_estiamte);
	
	// Debug code to check values
	error_log("Prepared by data: " . print_r([
		'name' => $row_estiamte["prepared_by_name"],
		'company' => $row_estiamte["prepared_by_company"],
		'mobile' => $row_estiamte["prepared_by_mobile"]
	], true));
	
	$class_desc=explode(",",$row_estiamte['description']);
	$class_qty=explode(",",$row_estiamte['quantity']);
	$class_rate=explode(",",$row_estiamte['rates']);
	$class_total=explode(",",$row_estiamte['amounts']);
	
	$tem_description=array();
	$tem_qty=array();
	$tem_rate=array();
	$tem_amount=array();
	$tem_completion_per=array();
	$tem_completion_terms=array();
	$sel_tem="select * from customer_payment_template_master where `quot_id`='$row_estiamte[quot_id]'";
	$result_tem = mysqli_query($conn, $sel_tem);
	if(mysqli_num_rows($result_tem))
	{
		while($row_tem=mysqli_fetch_array($result_tem))
		{
			array_push($tem_description,$row_tem["description"]);
			array_push($tem_qty,$row_tem["qty"]);
			array_push($tem_rate,$row_tem["rate"]);
			array_push($tem_amount,$row_tem["amount"]);
			array_push($tem_completion_per,$row_tem["completion_per"]);
			array_push($tem_completion_terms,$row_tem["completion_terms"]);
		}
	}
    ?>
	<!DOCTYPE html>
<html>
<head>

    <title>LIMS Proposal - <?php echo $row_estiamte["company_name"];?> - Quotation</title>
    <meta name="title" content="LIMS Proposal - <?php echo $row_estiamte["company_name"];?> - Quotation">
    <meta name="description" content="LIMS Proposal for <?php echo $row_estiamte["company_name"];?>">
    <style>
      
        /* Reset default margins and ensure box-sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: "TR Book Antiqua" !important; */
            /* font-weight:500 !important; */
            text-align: justify;
        }

        /* Define A4 page size for printing */
        @page {
            size: A4;
            margin: 10px;
        }

        
        /* Style for each page container */
        .page {
            border: 8px solid gray;
            width: 25cm;
            height: 34.8cm;
            position: relative;
            padding: 1cm;
            margin: 0.4cm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            font-family: 'Nunito', sans-serif;
            page-break-after: always !important;`
        }
        

        .page-content {
            position: relative;
            height: 100%;
            z-index: 2;
            /* padding: 1cm; */
        }

        .background-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            width: 100%;
            z-index: 1;
        }

        .header-logo {
            width: 300px;
            margin: 20px auto;
            display: block;
        }

        .proposal-title {
            text-align: center;
            font-size: 60px;
            font-weight: 500;
            line-height: 80px;
            margin: 270px 0px 0px 0px;
            font-family: 'Nunito', sans-serif;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            /* padding: 0 50px; */
        }

        .contact-section {
            width: 45%;
        }

        .contact-section h3 {
            font-size: 16px;
            font-weight: 900;
            margin-bottom: 15px;
            font-family: 'Nunito', sans-serif;
        }

        .contact-section p {
            font-size: 18px;
    margin: 5px 0;
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
        }

        .page-number {
            position: absolute;
            bottom: 20px;
            /* left: 20px; */
            font-size: 16px;
           
            border-top: 2px solid rgb(221, 219, 219);
            width: 100%;
            padding-top:10px ;  
            font-weight: 800 !important;
            font-family: 'Nunito', sans-serif;
        }
      
    </style>
</head>
<body>
    <!-- Page 1 -->
    <div class="page">
        <div class="page-content">
            <div style="text-align: right; clear: both; overflow: hidden; margin-bottom: 20px;">
            <img src="full_logo.jpeg" alt="Logo" class="header-logo" style="float: right; margin-right: 0px;">
            </div>
                
            <img src="full_logo.jpeg" alt="Background Logo" class="background-logo">
            
            <h1 class="proposal-title"><?php echo $row_estiamte["quotation_title"];?></h1>
            
            <!-- <div class="contact-info">
                <div class="contact-section">
                    <h3>Prepared for:</h3>
                    <p>MR. <?php echo $row_estiamte["contact_person1"];?></p>
                    <p><?php echo $row_estiamte["company_name"];?></p>
                    <p><?php echo $row_estiamte["city"];?></p>
                    <p><?php echo $row_estiamte["contact_number1"];?></p>
                </div>
                <div class="contact-section">
                    <h3>Prepared by:</h3>
                    <p>MR. <?php echo $row_estiamte["prepared_by_name"]; ?></p>
                    <p><?php echo $row_estiamte["prepared_by_company"]; ?></p>
                    <?php if(!empty($row_estiamte["prepared_by_mobile"])) { ?>
                    <p>(+91) <?php echo $row_estiamte["prepared_by_mobile"]; ?></p>
                    <?php } ?>
                </div>
            </div> -->
            
            <div class="page-number">1 | Page</div>
            
            <br>
        </div>
    </div>

<!-- Page 2 new  -->
<div class="page" style="font-family:TR Book Antiqua;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(100, 150, 200, 0.06); font-size: 48px; font-weight: bold;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative; ">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 5px; text-align: center; margin-top: 50px;">Commercial Proposal</div>
                        <div style="font-size: 20px; font-weight: 600; margin-bottom: 5px; ">
                            Date: <?php echo date('d/m/Y', strtotime($row_estiamte["quot_date"])); ?>
                        </div>
</div>
<!-- Inserted client info block -->
<div style="border-top:3px solid #888; border-bottom:3px solid #888; margin: 20px 0; padding: 20px 0; text-align:center; line-height: 30px; font-size: 24px; font-family:TR Book Antiqua;">
    <span style="font-weight:bold;">Client Name:</span> <?php echo htmlspecialchars($row_estiamte['contact_person1']); ?><br>
    <span style="font-weight:bold;"><?php echo htmlspecialchars($row_estiamte['company_name']); ?></span><br>
    <span style="font-size: 20px;   font-weight: 400; "><?php echo htmlspecialchars($row_estiamte['address']); ?></span>
</div>
                        
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">1. Introduction</div>
                        <div style="font-size: 20px; margin-left: 20px; line-height: 30px; text-align: justify; margin-bottom: 20px;">We appreciate the opportunity to submit this proposal for Custom Software Solutions. Our goal is to provide
tailored software applications that meet your unique business needs, enhance operational efficiency, and drive
innovation. By leveraging the latest technologies and best practices, we aim to empower your organization to
achieve its objectives and stay ahead in a competitive market.
</div>
<div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">2. Company Overview</div>
                        <div style="font-size: 20px; margin-left: 20px; line-height: 30px; text-align: justify; margin-bottom: 20px;">Chitri Enlargesoft IT Hub Pvt. Ltd. is based in Surat, Gujarat. A city that is perfect for software nearshoring
                        because of its location and time zone. <br> 
                        We are well-known for providing high-quality, dependable, and timely delivery of IT services with tailor-made
requirements for all facets of the business development to a vast collection of clienteles. We have professional
developers with extensive industry knowledge and abilities to analyze your company's requirements and build
the best solution for you. We provide feature-rich IT solutions that improve the user experience while also
assisting you in establishing market authority and expanding your brand.
</div>
<div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">3. Understanding Your Needs</div>
                        <div style="font-size: 20px; margin-left: 20px; line-height: 30px; text-align: justify;">Based on our discussions and our understanding of your requirements, we recognize that you are facing
challenges such as:
<ul style="font-size:20px; margin-left:20px; margin-bottom:20px; list-style-type: disc;">
    <li><strong>Inefficient Processes:</strong> Current systems may be hindering productivity and leading to time-consuming manual tasks.</li>
    <li><strong>Integration Issues:</strong> Difficulty in connecting various tools and platforms, resulting in data silos and miscommunication.</li>
    <li><strong>Scalability Concerns:</strong> Your existing solutions may not support your growth plans or adapt to changing market demands.</li>
    <li><strong>User Experience:</strong> There may be a need for a more intuitive interface to enhance user engagement and satisfaction.</li>
</ul>
Our proposed solutions are tailored to address these challenges effectively, ensuring that your operations
become more streamlined, integrated, and scalable.
</div>
                       
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%;">2 | Page</div>
        <!-- Page number at bottom -->
        
    </div>


    <!-- Page 2 -->
    <div class="page" style="font-family:TR Book Antiqua;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(100, 150, 200, 0.06); font-size: 48px; font-weight: bold;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative; ">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 26px; font-weight: 600; margin-bottom: 5px;">&#10020; Greetings from CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)</div>
                        <div style="font-size: 18px; margin-left: 20px; margin-bottom: 25px;">We develop LIMS so you don't have to</div>
                        
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 5px;">&#10020; What to Expect</div>
                        <ul style="font-size: 18px; margin-left: 20px; margin-bottom: 25px; list-style-type: disc;">
                            <li>Research and outreach</li>
                            <li>Framework</li>
                            <li>Development</li>
                            <li>Testing and launch</li>
                        </ul>
                        
                        <div style="font-size: 25px; font-weight: 700; margin-bottom: 5px;">Timeline</div>
                        <div style="font-size: 25px; font-weight: 700; margin-bottom: 5px;">Expenses</div>
                        <div style="font-size: 25px; font-weight: 700; margin-bottom: 30px;">Agreement</div>
                        
                        <div style="font-size: 26px; font-weight: 600; margin-bottom: 5px;">&#10020; Greetings from CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)</div> <br><br>
                        <div style="font-size: 24px; margin-bottom: 20px;">Dear,  <?php echo htmlspecialchars($row_estiamte['contact_person1']); ?></div>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            I am pleased to introduce myself and my company, <strong>CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)</strong>. We are excited to get to work on your new LIMS, and we want to make sure you're satisfied with our proposal and have a full understanding of what to expect in this lengthy process. Creating LIMS is exciting, and our expert team is fully capable of giving you something unique that will help grow your business.
                        </div>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 40px;">
                            The following proposal will set a project road map from start to finish. You will have a complete understanding of the process and timeline for completion. And if you have any questions or concerns, please contact me personally.
                        </div> <br>
                        
                        <div style="font-size: 24px;">Sincerely,</div> <br>
                        <div style="font-size: 18px; margin-bottom: 10px; font-weight: 600;">MR. CHINTAN KACHHADIYA</div>
                        <div style="font-size: 18px; margin-bottom: 10px; font-weight: 600;">CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)</div>
                        <div style="font-size: 18px; font-weight: 600;">(+91) 72763 23999</div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style=" width:91%;">3 | Page</div>
        <!-- Page number at bottom -->
        
    </div>

    <!-- Page 3 -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(100, 150, 200, 0.06); font-size: 48px; font-weight: bold;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 5px;">We develop LIMS so you don't have to</div> <br><br>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            We are living in the age of connectivity, and that means more things than ever before are right at your fingertips — literally. With one press of the button, one swipe left or right, you can open up new worlds in seconds. We're talking about LIMS.
                        </div> <br>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            But at Enlargesoft, we don't just talk about LIMS; we live and breathe LIMS. We have assembled a team of the best and brightest minds in LIMS development, marketing, and leadership, giving our clients access to the most cutting-edge technology. You can rest assured you're in good hands, as we have years of experience in LIMS development.
                        </div> <br>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            Our goal is to create something you're proud of and that helps your business. LIMS can be transcendent, and they can also be colossal failures. That's why Enlargesoft has developed a comprehensive approach to LIMS development that takes the guessing out of the game. We're ecstatic that you're considering doing business with us, so let's get started.
                        </div> <br>
                        
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 5px;">What to Expect</div> <br>
                        
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            LIMS development is serious business. It takes time and patience to create something that works for you and is free of bugs and other issues. Updates are required, but it's important to start with a sound foundation. At Enlargesoft, we believe in a thorough approach that provides our clients with as much engagement as they request. While our entire team will be developing your LIMS, we will assign a project lead who will be your main point of contact.
                        </div> <br>
                        
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 5px;">Research and outreach</div> <br>
                         
                        <div style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                            A large part of the work Enlargesoft does is behind the scenes. There will be times when we don't communicate with Enlargesoft for weeks, but that's only because we're intimately involved in the development phase. However, before any of that begins, we need to make a checklist of everything you want in your new LIMS.
                        </div> <br>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style=" width:91%;">4 | Page</div>
    </div>

    <!-- Page 4 -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(100, 150, 200, 0.06); font-size: 48px; font-weight: bold;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%; ">
            <table style="width: 100%; height: 100%;">
                <tr>
                    <td style="vertical-align: top;">
                        <div style="font-size: 18px; line-height: 2; margin-bottom: 30px;">
                            We will gather information about your company and how it works. We will figure out who your customers are and how we can attract more through your new LIMS. Audience engagement, research, and branding are key in LIMS development, and we will conduct focus groups to find out why people choose <b><p><?php echo $row_estiamte["company_name"];?></b>.</p>
                        </div>

                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">Framework</div>

                        <div style="font-size: 18px; line-height: 2; margin-bottom: 30px;">
                            Like a LIMS, LIMS needs a sitemap and wireframes. Think of this as the structural integrity of a skyscraper. Will have an important role in the design process, as it's important that you are getting what you want. Plus, it's better workable issues in this stage than later down the road. Here are some highlights of this process:
                        </div>

                        <div style="font-size: 18px; line-height: 2; margin-left: 40px; margin-bottom: 30px;">
                            • Functionality and content<br>
                            • Wireframes, the structural core of your app<br>
                            • Branding and integration of existing digital platforms (i.e., web and email)<br>
                            • User Experience and User Interface, or UX and UI — essentially, how you interact with the app, what makes it easy to use and desirable
                        </div>

                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">Testing and launch</div>

                        <div style="font-size: 18px; line-height: 2; margin-bottom: 20px;">
                            We're almost there. Your new LIMS is built and ready to launch. But before that happens, <b> CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL) and <p><?php echo $row_estiamte["company_name"];?></b> need to collaborate on a marketing strategy. After all, just because you invested all this time and money into your LIMS, it doesn't mean anyone will know it exists unless we tell them </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style=" width:91%;">5 | Page</div>
    </div>

    <!-- Page 5 -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
           
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%;">
            <table style="width: 100%; height: 100%;">
                <tr>
                    <td style="vertical-align: top;">
                        <table class="inner-table" cellspacing="0" style="width:100%; border-collapse:separate; margin:20px 0; border-radius:8px; overflow:hidden;">
                            <tr>
                                <td colspan="4" style="font-size:20px;  color:#333; line-height:1.6; background:#fff; border-radius:8px 8px 0 0;">
                                    Enlargesoft estimates that it will take <?php echo $row_estiamte["completion_time"]; ?>  to complete your new LIMS. Upon signing this agreement, we can begin immediately. Here's what to expect:
                                </td> 
                            </tr>
                            <tr><td colspan="4" style="height:45px;"></td></tr>
                            <tr>
                                <td colspan="4" style="background:#3B86B3; color:white; text-align:center; font-size:22px; padding:15px; border-radius:8px 8px 0 0;">
                                    Timeline for LIMS Development
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="background:#f5f6f7; color:#333; padding:15px; font-size:18px; font-weight:700; border:1px solid #ddd;">
                                    Process
                                </td>
                                <td colspan="2" style="background:#f5f6f7; color:#333; padding:15px; font-size:18px; font-weight:700; border:1px solid #ddd;">
                                    Delivery
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:15px; border:1px solid #ddd; border-radius:0 0 0 8px; font-weight: 600;">
                                    Development For LIMS
                                </td>
                                <td colspan="2" style="padding:15px; border:1px solid #ddd; border-radius:0 0 8px 0; font-weight: 600; "> 
                                    <?php echo $row_estiamte["completion_time"]; ?> 
                                </td>
                            </tr>
                        </table>

                        <table class="inner-table" cellspacing="0">
                            <tr><td><br></td></tr>
                            <tr>
                                <td colspan="4" class="font-22" Style="font-size:35px; color:#333; line-height:1.6; ">Expenses <br> </td>
                            </tr>
                            <tr>
                                <td colspan="4" Style="font-size:20px;  color:#333; line-height:1.6;  ">We want to receive the utmost value from your investment in new LIMS. This budget breakdown is based on the project outline described above. Please contact your project lead with any issues or questions before signing.</td>
                            </tr>
                            <tr><td><br> <br><br></td></tr>
                            <tr>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; border-radius:8px 0 0 0; text-align:left; border:1px solid #ddd;">Description</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd;">Price</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd;">Qty</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border-radius:0 8px 0 0; border:1px solid #ddd;">Subtotal</td>
                            </tr>
                            <?php foreach($class_desc as $kk => $one_desc){?>
                            <tr>
                                <td style="padding:12px 15px; width:25%; text-align:left; border:1px solid #ddd; font-weight:700;"><?php echo $class_desc[$kk];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $class_rate[$kk];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $class_qty[$kk];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $class_total[$kk];?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="2" style="border:1px solid #ddd;"></td>
                                <td style="padding:12px 15px; font-weight:600; text-align:right; border:1px solid #ddd;">Subtotal</td>
                                <td style="padding:12px 15px; font-weight:600; text-align:center; border:1px solid #ddd;"><?php echo $row_estiamte["contract_amount"];?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border:1px solid #ddd; border-radius:0 0 0 8px;"></td>
                                <td style="padding:12px 15px; font-weight:700; text-align:right;  border:1px solid #ddd;">Total</td>
                                <td style="padding:12px 15px; font-weight:900; text-align:center; border-radius:0 0 8px 0;   border:1px solid #ddd;"><?php echo $row_estiamte["contract_amount"];?></td>
                            </tr>
                        </table>
<table>
                        <tr>
                            <td style="font-weight: 600; padding: 12px 0;">- Annual Renewal Charge: <?php echo $row_estiamte["amc_amount"];  ?>/- Per Year & Per Lab.</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700; padding: 12px 0;">Payment Terms:</td>
                        </tr>
                        <?php foreach($tem_description as $dd => $one_tem) { ?>
                        <tr>
                            <td style="padding: 8px 25px; font-weight: 500; letter-spacing: 0.8px;"><span style="display: inline-block; width: 8px; height: 8px; background-color: #000; border-radius: 50%; margin-right: 10px;"></span><?php echo $tem_description[$dd] . ' - ' . $tem_completion_per[$dd]; ?> % </td>
                        </tr>
                        <?php } ?>
</table>
                        
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style=" width:91%;">6 | Page</div>
    </div>

    <!-- Page 6 -->
    <div class="page">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
           
        </div>
        <table class="page-table">
            <tr>
                <td><?php if(!empty($tem_description)) {?>
                        <table class="inner-table" cellspacing="0">
                            <tr>
                                <td colspan="4" class="font-22" Style="font-size:25px; padding-top:15px;  color:#333; line-height:2.6; font-weight: 600; ">Payment Partition <br> </td>
                            </tr>
                            <tr>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; border-radius:8px 0 0 0; text-align:left; border:1px solid #ddd;">Description</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd;">Completion Percentage</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd;">Completion Term</td>
                                <td class="blue-header" style="width:25%; background:#3B86B3; color:white; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border-radius:0 8px 0 0; border:1px solid #ddd;">Amount</td>
                            </tr>
                            <?php foreach($tem_description as $dd => $one_tem){?>
                            <tr>
                                <td style="padding:12px 15px; width:25%; text-align:left; border:1px solid #ddd; font-weight:700; border-radius:0px 0 0px 8px;"><?php echo $tem_description[$dd];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $tem_completion_per[$dd];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $tem_completion_terms[$dd];?></td>
                                <td style="padding:12px 15px; width:25%; text-align:center; border:1px solid #ddd; font-weight:600; border-radius:0 0 8px 0px;"><?php echo $tem_amount[$dd];?></td>
                            </tr>
                            <?php } ?>
                        </table>
                        <?php } ?>
                    <table class="inner-table bordered-inner-table" cellspacing="0">
                        <tr>
                            <td style="font-size:25px; padding-top:15px;  color:#333; line-height:1.6; font-weight: 600;" class="bold">Terms & Conditions:</td>
                           
                        </tr>
                    </table>
                    <table class="inner-table">
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">1. Quotation is valid till one week from send date. After the expiration of this period, the Quotation may be subject to changes.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">2. 18% GST will be extra</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">3. We will deliver the Software in accordance with the specifications and milestones detailed in the Quotation. Any delays in the project timeline will be communicated to the Client promptly.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">4. The Client agrees to provide all necessary materials, access, and cooperation required for the successful completion of the project. Delays caused by the Client may result in an extension of the project timeline and additional charges.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">5. Both parties agree to treat any confidential information exchanged during the course of the project as confidential and not to disclose it to third parties.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">6. This Agreement constitutes the entire understanding between the parties and supersedes any prior agreements or understandings, whether oral or written</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">7. Accommodation charges will be in your scope.</td>
                        </tr>
                        <tr>
                            <td style="padding-left:25px; font-size:20px; line-height:1.8;">8. Payments made are strictly non-refundable. By completing transaction, you agree to these terms without exception.</td>
                        </tr>
                        <?php 
                        if(!empty($row_estiamte['custom_terms'])) {
                            $terms = explode('||', $row_estiamte['custom_terms']);
                            $term_count = 8;
                            foreach($terms as $term) {
                                if(!empty(trim($term))) {
                                    echo '<tr>';
                                    echo '<td style="padding-left:25px; font-size:20px; line-height:1.8;">'.$term_count.'. '.htmlspecialchars($term).'</td>';
                                    echo '</tr>';
                                    $term_count++;
                                }
                            }
                        }
                        ?>
						<tr><td><br></td></tr>	
                    </table>
                    
                </td>
            </tr>
        </table>
        <div class="page-number" style=" width:91%;">7 | Page</div>
    </div>
	 <!-- Page 7 -->
    <div class="page">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
           
        </div>
        <table class="page-table">
            <tr>
                <td>
                <table class="inner-table" style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                        <tr>
                            <td colspan="4" style="background: #3B86B3; color: white; padding: 15px 20px; font-size: 24px; font-weight: 500; border-radius: 8px 8px 0 0;">
                                Bank Details
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 15px 20px; font-size: 16px; font-weight: 600; color: #333; background: #f8f9fa; border: 1px solid #dee2e6;">
                                Account No.
                            </td>
                            <td colspan="3" style="padding: 15px 20px; font-size: 16px; color: #444;font-weight: 600; border: 1px solid #dee2e6;">
                                001161900016923
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 15px 20px; font-size: 16px; font-weight: 600; color: #333; background: #f8f9fa; border: 1px solid #dee2e6;">
                                IFSC Code
                            </td>
                            <td colspan="3" style="padding: 15px 20px; font-size: 16px; color: #444;  font-weight: 600; border: 1px solid #dee2e6;">
                                YESB0000011
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 15px 20px; font-size: 16px; font-weight: 600; color: #333; background: #f8f9fa; border: 1px solid #dee2e6;">
                                Name
                            </td>
                            <td colspan="3" style="padding: 15px 20px; font-size: 16px; color: #444;font-weight: 600; border: 1px solid #dee2e6;">
                                CHITRI ENLARGE SOFT IT HUB PVT LTD
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%; padding: 15px 20px; font-size: 16px; font-weight: 600; color: #333; background: #f8f9fa; border: 1px solid #dee2e6; ">
                                Branch
                            </td>
                            <td colspan="3" style="padding: 15px 20px; font-size: 16px; color: #444;font-weight: 600; border: 1px solid #dee2e6;">
                                YES BANK LTD,GR FLOOR, MANGALDEEP, RING ROAD, NEAR MAHAVIR HOSPITAL, NEAR RTO, SURAT – 395001.
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;"></td>
                        </tr>
                    </table>
                    <table class="inner-table " cellspacing="0">
                        <tr>
                            <td class="bold" Style="font-size:24px;">Agreement <br> <br></td>
                        </tr>
                    </table>
                    <table class="inner-table">
                        <tr>
                            <td style="font-size:20px; line-height:1.8;">By signing below, you agree to accept this proposal for LIMS development and any modifications already agreed upon with CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL).</td>
                           
                        </tr>
						<tr><td><br></td></tr>	
                    </table>
                    <table class="inner-table" style="width: 100%;">
                        <tr>
                            <td style="width: 45%;">
                                <div style="background: linear-gradient(to bottom right, #ffffff, #f8f9fa); border-radius: 16px;  padding: 2px;">
                                    <div style="background: #3B86B3; border-radius: 15px 15px 0 0; padding: 15px 25px;">
                                        <h3 style="font-size: 20px; color: #ffffff; margin: 0; letter-spacing: 0.5px; font-weight: 600;">CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)</h3>
                                    </div>
                                    <div style="padding: 25px;">
                                        <div style="margin-bottom: 25px;">
                                            <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Authorized Signatory</label>
                                            <p style="font-size: 19px; color: #2c3e50; margin: 0; font-weight: 600; border-bottom: 2px solid #3B86B3; padding-bottom: 8px; display: inline-block;">MR.  <?php echo $row_estiamte["prepared_by_name"]; ?></p>
                                        </div>
                                        
                                        <div style="border: 2px dashed rgb(190, 190, 190); height: 100px; margin: 30px 0; background: rgba(59,134,179,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #3B86B3; font-style: italic; font-size: 16px;"></span>
                                        </div>
                                        
                                        <div style="margin-top: 25px;">
                                            <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Date</label>
                                            <div style="border-bottom: 2px solid #3B86B3; padding: 8px 0;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td style="width: 10%;"></td>
                            
                            <td style="width: 45%;">
                                <div style="background: linear-gradient(to bottom right, #ffffff, #f8f9fa); border-radius: 16px; padding: 2px;">
                                    <div style="background: #3B86B3; border-radius: 15px 15px 0 0; padding: 15px 25px;">
                                        <h3 style="font-size: 20px; color: #ffffff; margin: 0; letter-spacing: 0.5px; font-weight: 600;"><?php echo $row_estiamte["company_name"];?></h3>
                                        </div>
                                    <div style="padding: 25px;">
                                        <div style="margin-bottom: 25px;">
                                            <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Authorized Signatory</label>
                                            <p style="font-size: 19px; color: #2c3e50; margin: 0; font-weight: 600; border-bottom: 2px solid #3B86B3; padding-bottom: 8px; display: inline-block;">MR. <?php echo $row_estiamte["contact_person1"];?></p>
                                        </div>
                                        
                                        <div style="border: 2px dashed rgb(190, 190, 190); height: 100px; margin: 30px 0; background: rgba(59,134,179,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #3B86B3; font-style: italic; font-size: 16px;"></span>
                                        </div>
                                        
                                        <div style="margin-top: 25px;">
                                            <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Date</label>
                                            <div style="border-bottom: 2px solid #3B86B3; padding: 8px 0;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
					
                    <div class="page-number" style=" width:91%;">8 | Page</div>
                </td>
            </tr>
        </table>
    </div>
    <!-- Page 6 -->
    <div class="page">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="full_logo.jpeg" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
           
        </div>
       <!-- Main content -->
       <div style="position: relative; ">
            <table style="width: 100%;">
                <tr>
                    <td>
                       
</div>

                        

<div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">&#10020; Why Choose Us?</div>
<div style="font-size: 20px; margin-left: 20px; line-height: 30px; text-align: justify;">
    <ul style="font-size:17px; font-weight: 500; margin-left:20px; margin-bottom:20px; list-style-type: disc; line-height: 30px;">
        <li><strong>Expertise and Experience:</strong> With years of experience in the industry, our team of experts brings extensive knowledge and proven methodologies to every project. We understand the unique challenges faced by businesses and are equipped to deliver tailored solutions that meet your specific needs.</li>
        <li><strong>Customized Solutions:</strong> We believe that every client is unique. Our approach involves closely collaborating with you to understand your goals and challenges, allowing us to create customized software solutions that align perfectly with your business objectives.</li>
        <li><strong>Commitment to Quality:</strong> Quality is at the forefront of everything we do. We adhere to industry best practices and rigorous testing protocols to ensure that our solutions are not only functional but also reliable, secure, and scalable.</li>
        <li><strong>Client-Centric Approach:</strong> Your satisfaction is our priority. We maintain open lines of communication throughout the project, providing regular updates and seeking your feedback to ensure that the final product exceeds your expectations.</li>
        <li><strong>Comprehensive Support:</strong> Our commitment doesn’t end with project delivery. We offer ongoing support and maintenance to address any issues that may arise and to help you adapt to evolving business needs, ensuring your software remains effective and relevant.</li>
        <li><strong>Innovative Technology:</strong> We leverage the latest technologies and tools to provide innovative solutions that enhance efficiency, productivity, and user experience. Our forward-thinking approach ensures that you stay ahead of the competition.</li>
        <li><strong>Proven Track Record:</strong> We have a history of successful projects and satisfied clients across various industries. Our portfolio showcases our ability to deliver results and drive positive outcomes for businesses like yours.</li>
        <li><strong>Cost-Effective Solutions:</strong> We understand the importance of budget considerations. Our solutions are designed to provide maximum value, helping you achieve your goals without compromising on quality.</li>
    </ul>
</div>
<div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">&#10020; Next Steps</div>
<div style="font-size: 17px; line-height: 2; margin-bottom: 20px; font-weight: 500;">
We look forward to the opportunity to work with you. Please feel free to reach out with any questions or to
discuss this proposal further. To proceed, please sign and return this proposal .
                        </div>              
                    </td>
                </tr>
                
                <table align="center" style="width:100%;">
                <div style=" margin-bottom: 20px; font-size: 20px; font-family: 'Book Antiqua', serif;">
                    <div style="font-weight: 600; margin-bottom: 10px; text-align: center;">Thank you for considering our proposal!</div>
                    <!-- <div style="margin-bottom: 8px;">Sincerely,</div>
                    <div style="font-weight: bold; font-size: 20px;">Chintan Patel</div>
                    <div style="font-size: 18px; font-weight: 500;">CMD</div>
                    <div style="font-size: 18px;">Chitri Enlargesoft IT Hub Pvt. Ltd.</div>
                    <div style="font-size: 18px;">Mo. (+91) 72763 23999</div>
                    <div style="font-size: 18px; margin-top: 5px;">
                        <a href="http://www.enlargesoftithub.com" style="color: #2176bd; text-decoration: underline;" target="_blank">www.enlargesoftithub.com</a>
                    </div> -->
                </div>
						<tr>
							<td style="text-align:Center;padding-top:0px;"><img src="thank-you.png" alt="logo" style="width:200px;height:200px;"></td>
						</tr>
						<tr>
                            <td style="height: 100%;"></td> <!-- Spacer -->
                        </tr>
					</table>
            </table>
        </div>
        <div class="page-number" style="width:91%;" >9| Page</div>
    </div>
	</center>
</body>
</html>
 