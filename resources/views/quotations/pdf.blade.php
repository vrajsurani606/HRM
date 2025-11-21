<!DOCTYPE html>
<html>

<head>
    <title>{{ $quotation->quotation_title }} - Quotation</title>
    <meta charset="utf-8">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        @page {
            size: A4;
            margin: 10px;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .page {
                page-break-after: always !important;
                break-after: page !important;
                box-shadow: none !important;
            }
        }

        body {
            font-family: 'Inter', 'Arial', sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .page {
            border: 8px solid #4a5568;
            width: 25cm;
            height: 35.8cm;
            position: relative;
            padding: 1cm;
            margin: 0.4cm auto;
            background: white !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: 'Inter', 'Arial', sans-serif;
            page-break-after: always !important;
            break-after: page !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .page-content {
            position: relative;
            height: 100%;
            z-index: 2;
        }

        .background-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
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
            font-size: 56px;
            font-weight: 700;
            line-height: 1.2;
            margin: 270px 0 0 0;
            font-family: 'Inter', 'Arial', sans-serif;
            letter-spacing: -0.02em;
            color: #1a1a1a;
        }

        .page-number {
            position: absolute;
            bottom: 20px;
            font-size: 14px;
            border-top: 2px solid #e2e8f0;
            width: 100%;
            padding-top: 10px;
            font-weight: 600;
            font-family: 'Inter', 'Arial', sans-serif;
            color: #4a5568;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-family: 'Inter', 'Arial', sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .modern-table th,
        .modern-table td {
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
            font-size: 15px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .modern-table th {
            background: #3B86B3 !important;
            color: #ffffff !important;
            font-weight: 700;
            text-align: center;
            font-size: 16px;
            letter-spacing: 0.01em;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .modern-table tr:nth-child(even) td {
            background: #f7fafc !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .modern-table td {
            color: #2d3748;
            font-weight: 500;
            text-align: center;
        }

        .modern-table .desc-col {
            text-align: left;
            font-weight: 600;
        }

        .modern-table tfoot td {
            background: #edf2f7 !important;
            font-weight: 700;
            color: #2c5282;
            font-size: 16px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', 'Arial', sans-serif;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.01em;
            color: #1a1a1a;
        }
        
        p, li, td, span, div {
            font-family: 'Inter', 'Arial', sans-serif;
            line-height: 1.7;
        }
        
        /* Ensure borders print */
        table, tr, td, th {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Ensure all backgrounds and colors print */
        [style*="background"] {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    </style>
</head>

<body>
    <!-- Page 1 - Cover -->
    <div class="page">
        <div class="page-content">
            <div style="text-align: right; clear: both; overflow: hidden; margin-bottom: 20px;">
                <img src="{{ asset('full_logo.jpeg') }}" alt="Logo" class="header-logo"
                    style="float: right; margin-right: 0px;">
            </div>

            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" class="background-logo">

            <h1 class="proposal-title">{{ $quotation->quotation_title }}</h1>

            <div class="page-number">1 | Page</div>
        </div>
    </div>

    <!-- Page 2 - Introduction -->
    <div class="page">
        <div
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.08;">
            <div
                style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(59, 134, 179, 0.04); font-size: 48px; font-weight: 700; letter-spacing: -0.02em;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <div style="position: relative;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div
                            style="font-size: 30px; font-weight: 700; margin-bottom: 6px; text-align: center; margin-top: 30px; letter-spacing: -0.01em; color: #1a1a1a;">
                            Commercial Proposal</div>
                        <div style="font-size: 16px; font-weight: 600; margin-bottom: 6px; color: #4a5568;">
                            Date: {{ $quotation->quotation_date->format('d/m/Y') }}
                        </div>

                        <div
                            style="border-top: 3px solid #3B86B3; border-bottom: 3px solid #3B86B3; margin: 16px 0; padding: 16px 0; text-align: center; line-height: 1.6; font-size: 18px;">
                            <span style="font-weight: 600; color: #2d3748;">Client Name:</span> <span style="color: #1a1a1a;">{{ $quotation->contact_person_1 }}</span><br>
                            <span style="font-weight: 700; font-size: 20px; color: #1a1a1a;">{{ $quotation->company_name }}</span><br>
                            <span style="font-size: 16px; font-weight: 400; color: #4a5568;">{{ $quotation->address }}</span>
                        </div>

                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 12px; margin-top: 20px; color: #1a1a1a; letter-spacing: -0.01em;">1. Introduction</div>
                        <div
                            style="font-size: 16px; margin-left: 0; line-height: 1.65; text-align: justify; margin-bottom: 16px; color: #2d3748;">
                            We appreciate the opportunity to submit this proposal for Custom Software Solutions. Our
                            goal is to provide tailored software applications that meet your unique business needs,
                            enhance operational efficiency, and drive innovation.
                        </div>

                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 12px; margin-top: 20px; color: #1a1a1a; letter-spacing: -0.01em;">2. Company Overview</div>
                        <div
                            style="font-size: 16px; margin-left: 0; line-height: 1.65; text-align: justify; margin-bottom: 16px; color: #2d3748;">
                            {{ $quotation->own_company_name ?? 'Chitri Enlargesoft IT Hub Pvt. Ltd.' }} is based in Surat, Gujarat. We are well-known for providing high-quality, dependable, and timely delivery of IT services with tailor-made requirements for all facets of business development. We have professional developers with extensive industry knowledge to build the best solution for you.
                        </div>

                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 12px; margin-top: 20px; color: #1a1a1a; letter-spacing: -0.01em;">3. Understanding Your Needs
                        </div>
                        <div style="font-size: 16px; margin-left: 0; line-height: 1.65; text-align: justify; color: #2d3748;">
                            Based on our discussions, we recognize that you are facing challenges such as:
                            <ul style="font-size: 16px; margin-left: 20px; margin-top: 8px; margin-bottom: 16px; list-style-type: disc; line-height: 1.65;">
                                <li style="margin-bottom: 6px;"><strong style="font-weight: 600; color: #1a1a1a;">Inefficient Processes:</strong> Current systems may be hindering productivity and leading to time-consuming manual tasks.</li>
                                <li style="margin-bottom: 6px;"><strong style="font-weight: 600; color: #1a1a1a;">Integration Issues:</strong> Difficulty in connecting various tools and platforms, resulting in data silos.</li>
                                <li style="margin-bottom: 6px;"><strong style="font-weight: 600; color: #1a1a1a;">Scalability Concerns:</strong> Your existing solutions may not support your growth plans.</li>
                                <li style="margin-bottom: 6px;"><strong style="font-weight: 600; color: #1a1a1a;">User Experience:</strong> Need for a more intuitive interface to enhance user engagement.</li>
                            </ul>
                            Our proposed solutions are tailored to address these challenges effectively.
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number">2 | Page</div>
    </div>

     <!-- Page 3 - Greetings -->
    <div class="page">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.08;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(59, 134, 179, 0.04); font-size: 48px; font-weight: 700; letter-spacing: -0.02em;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #1a1a1a; letter-spacing: -0.01em;">&#10020; Greetings from {{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}</div>
                        <div style="font-size: 17px; margin-left: 0; margin-bottom: 28px; color: #4a5568; line-height: 1.6;">We develop {{ $quotation->quotation_title ?? 'Software' }} so you don't have to</div>
                        
                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 12px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">&#10020; What to Expect</div>
                        <ul style="font-size: 17px; margin-left: 24px; margin-bottom: 28px; list-style-type: disc; line-height: 1.8; color: #2d3748;">
                            <li style="margin-bottom: 6px;">Research and outreach</li>
                            <li style="margin-bottom: 6px;">Framework</li>
                            <li style="margin-bottom: 6px;">Development</li>
                            <li style="margin-bottom: 6px;">Testing and launch</li>
                        </ul>
                        
                        <div style="font-size: 22px; font-weight: 700; margin-bottom: 8px; margin-top: 24px; color: #2d3748;">Timeline</div>
                        <div style="font-size: 22px; font-weight: 700; margin-bottom: 8px; color: #2d3748;">Expenses</div>
                        <div style="font-size: 22px; font-weight: 700; margin-bottom: 32px; color: #2d3748;">Agreement</div>
                        
                        <div style="font-size: 24px; font-weight: 700; margin-bottom: 8px; margin-top: 40px; color: #1a1a1a; letter-spacing: -0.01em;">&#10020; Greetings from {{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}</div>
                        <div style="margin-bottom: 24px;"></div>
                        <div style="font-size: 20px; margin-bottom: 24px; color: #1a1a1a; font-weight: 600;">Dear {{ $quotation->contact_person_1 }},</div>
                        
                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">
                            I am pleased to introduce myself and my company, <strong style="font-weight: 600; color: #1a1a1a;">{{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}</strong>. We are excited to get to work on your new {{ $quotation->quotation_title ?? 'Software' }}, and we want to make sure you're satisfied with our proposal and have a full understanding of what to expect in this lengthy process. Creating {{ $quotation->quotation_title ?? 'Software' }} is exciting, and our expert team is fully capable of giving you something unique that will help grow your business.
                        </div>
                        
                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 48px; text-align: justify; color: #2d3748;">
                            The following proposal will set a project road map from start to finish. You will have a complete understanding of the process and timeline for completion. And if you have any questions or concerns, please contact me personally.
                        </div>
                        
                        <div style="font-size: 20px; margin-top: 40px; margin-bottom: 16px; color: #1a1a1a; font-weight: 600;">Sincerely,</div>
                        <div style="font-size: 17px; margin-bottom: 8px; font-weight: 600; color: #2d3748;">{{ $quotation->prepared_by ?? 'MR. CHINTAN KACHHADIYA' }}</div>
                        <div style="font-size: 17px; margin-bottom: 8px; font-weight: 600; color: #2d3748;">{{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}</div>
                        <div style="font-size: 17px; font-weight: 600; color: #2d3748;">(+91) {{ $quotation->mobile_no ?? '72763 23999' }}</div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%;">3 | Page</div>
    </div>

    <!-- Page 4 - Development Process --> 
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.08;">
                <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(59, 134, 179, 0.04); font-size: 48px; font-weight: 700; letter-spacing: -0.02em;">
                            IT Hub Pvt. Ltd.            
                </div>       
        </div>
        <!-- Main content -->
        <div style="position: relative;">
            <tr>
                <td>                        
                    <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; color: #1a1a1a; letter-spacing: -0.01em;">We develop {{ $quotation->quotation_title ?? 'Software' }} so you don't have to</div>
                    <div style="margin-bottom: 24px;"></div>
                    <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">We are living in the age of connectivity, and that means more things than ever before are right at your fingertips — literally. With one press of the button, one swipe left or right, you can open up new worlds in seconds. We're talking about {{ $quotation->quotation_title ?? 'Software' }}.</div>
                    <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">But at {{ $quotation->own_company_name ?? 'Enlargesoft' }}, we don't just talk about {{ $quotation->quotation_title ?? 'Software' }}; we live and breathe {{ $quotation->quotation_title ?? 'Software' }}. We have assembled a team of the best and brightest minds in {{ $quotation->quotation_title ?? 'Software' }} development, marketing, and leadership, giving our clients access to the most cutting-edge technology. You can rest assured you're in good hands, as we have years of experience in {{ $quotation->quotation_title ?? 'Software' }} development.</div>
                    <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">Our goal is to create something you're proud of and that helps your business. {{ $quotation->quotation_title ?? 'Software' }} can be transcendent, and they can also be colossal failures. That's why {{ $quotation->own_company_name ?? 'Enlargesoft' }} has developed a comprehensive approach to {{ $quotation->quotation_title ?? 'Software' }} development that takes the guessing out of the game. We're ecstatic that you're considering doing business with us, so let's get started.</div>
                    <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">What to Expect</div>
                    <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">{{ $quotation->quotation_title ?? 'Software' }} development is serious business. It takes time and patience to create something that works for you and is free of bugs and other issues. Updates are required, but it's important to start with a sound foundation. At {{ $quotation->own_company_name ?? 'Enlargesoft' }}, we believe in a thorough approach that provides our clients with as much engagement as they request. While our entire team will be developing your {{ $quotation->quotation_title ?? 'Software' }}, we will assign a project lead who will be your main point of contact.</div>
                    <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">Research and outreach</div>
                    <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">A large part of the work {{ $quotation->own_company_name ?? 'Enlargesoft' }} does is behind the scenes. There will be times when we don't communicate with {{ $quotation->own_company_name ?? 'Enlargesoft' }} for weeks, but that's only because we're intimately involved in the development phase. However, before any of that begins, we need to make a checklist of everything you want in your new {{ $quotation->quotation_title ?? 'Software' }}.</div>
                </td>                
            </tr>        
        </div>
        <div class="page-number" style="width:91%;">4 | Page</div>
    </div>


                          

    <!-- Page 5 - Framework and Testing -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.08;">
            <div style="position: absolute; bottom: 40%; left: 0; right: 0; text-align: center; color: rgba(59, 134, 179, 0.04); font-size: 48px; font-weight: 700; letter-spacing: -0.02em;">
                IT Hub Pvt. Ltd.
            </div>
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%;">
            <table style="width: 100%; height: 100%;">
                <tr>
                    <td style="vertical-align: top;">
                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 32px; text-align: justify; color: #2d3748;">
                            We will gather information about your company and how it works. We will figure out who your customers are and how we can attract more through your new {{ $quotation->quotation_title ?? 'Software' }}. Audience engagement, research, and branding are key in {{ $quotation->quotation_title ?? 'Software' }} development, and we will conduct focus groups to find out why people choose <strong style="font-weight: 600; color: #1a1a1a;">{{ $quotation->company_name }}</strong>.
                        </div>

                        <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">Framework</div>

                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">
                            Like a {{ $quotation->quotation_title ?? 'Software' }}, {{ $quotation->quotation_title ?? 'Software' }} needs a sitemap and wireframes. Think of this as the structural integrity of a skyscraper. Will have an important role in the design process, as it's important that you are getting what you want. Plus, it's better workable issues in this stage than later down the road. Here are some highlights of this process:
                        </div>

                        <div style="font-size: 17px; line-height: 1.8; margin-left: 24px; margin-bottom: 32px; color: #2d3748;">
                            • Functionality and content<br>
                            • Wireframes, the structural core of your app<br>
                            • Branding and integration of existing digital platforms (i.e., web and email)<br>
                            • User Experience and User Interface, or UX and UI — essentially, how you interact with the app, what makes it easy to use and desirable
                        </div>

                        <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">Testing and launch</div>

                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 24px; text-align: justify; color: #2d3748;">
                            We're almost there. Your new {{ $quotation->quotation_title ?? 'Software' }} is built and ready to launch. But before that happens, {{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }} and {{ $quotation->company_name }} need to collaborate on a marketing strategy. After all, just because you invested all this time and money into your {{ $quotation->quotation_title ?? 'Software' }}, it doesn't mean anyone will know it exists unless we tell them.
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%">5 | Page</div>
    </div>

    <!-- Page 6 - Timeline and Expenses -->    
    <div class="page" style="position: relative;">
        <!-- Background watermark -->        
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">            
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.08;">        
        </div>
        <!-- Main content -->        
        <div style="position: relative; height: 100%;">
            <table style="width: 100%; height: 100%;">
                <tr>                            
                <td style="vertical-align: top;">                                        
                    <table class="inner-table" cellspacing="0" style="width:100%; border-collapse:separate; margin:20px 0; border-radius:8px; overflow:hidden;">                                                
                        <tr>                                                        
                            <td colspan="4" style="font-size:17px; color:#2d3748; line-height:1.8; background:#fff; border-radius:8px 8px 0 0; text-align: justify;">{{ $quotation->own_company_name ?? 'Enlargesoft' }} estimates that it will take {{ $quotation->completion_time ?? '90 Days' }} to complete your new {{ $quotation->quotation_title ?? 'Software' }}. Upon signing this agreement, we can begin immediately. Here's what to expect:</td>                                                                            
                        </tr>                                                
                        <tr>
                            <td colspan="4" style="height:32px;"></td>
                        </tr>                                                
                        <tr>                                                        
                            <td colspan="4" style="background:#3B86B3 !important; color:#ffffff !important; text-align:center; font-size:18px; font-weight:700; padding:16px; border-radius:8px 8px 0 0; letter-spacing:0.01em; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Timeline for {{ $quotation->quotation_title ?? 'Software' }} Development</td>                                                    
                        </tr>                                                
                        <tr>                                                        
                            <td colspan="2" style="background:#f7fafc !important; color:#1a1a1a; padding:14px 16px; font-size:16px; font-weight:700; border:1px solid #e2e8f0; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Process</td>                                                        
                            <td colspan="2" style="background:#f7fafc !important; color:#1a1a1a; padding:14px 16px; font-size:16px; font-weight:700; border:1px solid #e2e8f0; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Delivery</td>                                                    
                        </tr>                                                
                        <tr>                                                        
                            <td colspan="2" style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:0 0 0 8px; font-weight:600; font-size:15px; color:#2d3748;">Development For {{ $quotation->quotation_title ?? 'Software' }}</td>                                                        
                            <td colspan="2" style="padding:14px 16px; border:1px solid #e2e8f0; border-radius:0 0 8px 0; font-weight:600; font-size:15px; color:#2d3748;">{{ $quotation->completion_time ?? '90 Days' }}</td>                                                    
                        </tr>                                            
                    </table>
                                            
                    <table class="inner-table" cellspacing="0">                                                
                        <tr>
                            <td><br></td>
                        </tr>                                                
                        <tr>                                                        
                            <td colspan="4" style="font-size:28px; font-weight:700; color:#1a1a1a; line-height:1.3; letter-spacing:-0.01em; margin-bottom:16px;">Expenses</td>                                                    
                        </tr>
                        <tr>
                            <td colspan="4" style="height:16px;"></td>
                        </tr>                                                
                        <tr>                                                        
                            <td colspan="4" style="font-size:17px; color:#2d3748; line-height:1.8; text-align:justify;">We want to receive the utmost value from your investment in new {{ $quotation->quotation_title ?? 'Software' }}. This budget breakdown is based on the project outline described above. Please contact your project lead with any issues or questions before signing.</td>                                                    
                        </tr>                                                
                        <tr>
                            <td colspan="4" style="height:32px;"></td>
                        </tr>                                                
                        <tr>                                                        
                            <td class="blue-header" style="width:25%; background:#3B86B3 !important; color:#ffffff !important; padding:14px 16px; font-size:15px; font-weight:700; border-radius:8px 0 0 0; text-align:left; border:1px solid #e2e8f0; letter-spacing:0.01em; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Description</td>
                                                            
                            <td class="blue-header" style="width:25%; background:#3B86B3 !important; color:#ffffff !important; padding:14px 16px; font-size:15px; font-weight:700; text-align:center; border:1px solid #e2e8f0; letter-spacing:0.01em; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Price</td>
                                                            
                            <td class="blue-header" style="width:25%; background:#3B86B3 !important; color:#ffffff !important; padding:14px 16px; font-size:15px; font-weight:700; text-align:center; border:1px solid #e2e8f0; letter-spacing:0.01em; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Qty</td>
                                                            
                            <td class="blue-header" style="width:25%; background:#3B86B3 !important; color:#ffffff !important; padding:14px 16px; font-size:15px; font-weight:700; text-align:center; border-radius:0 8px 0 0; border:1px solid #e2e8f0; letter-spacing:0.01em; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Subtotal</td>                                                    
                        </tr>
                                                    @if($quotation->service_description && count($quotation->service_description) > 0)                                @foreach($quotation->service_description as $index => $description)                                    @if(trim($description) !== '')                                        
                        <tr>                                                                    
                            <td style="padding:14px 16px; width:25%; text-align:left; border:1px solid #e2e8f0; font-weight:600; font-size:15px; color:#2d3748;">{{ $description }}</td>                                                                    
                            <td style="padding:14px 16px; width:25%; text-align:center; border:1px solid #e2e8f0; font-weight:500; font-size:15px; color:#2d3748;">{{ number_format($quotation->service_rate[$index] ?? 0, 2) }}</td>                                                                    
                            <td style="padding:14px 16px; width:25%; text-align:center; border:1px solid #e2e8f0; font-weight:500; font-size:15px; color:#2d3748;">{{ $quotation->service_quantity[$index] ?? 0 }}</td>                                                                    
                            <td style="padding:14px 16px; width:25%; text-align:center; border:1px solid #e2e8f0; font-weight:600; font-size:15px; color:#1a1a1a;">{{ number_format($quotation->service_total[$index] ?? 0, 2) }}</td>                                                                
                        </tr>
                                                            @endif                                @endforeach                            @endif                            
                        <tr>                                                        
                            <td colspan="2" style="border:1px solid #e2e8f0; background:#f7fafc !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;"></td>                                                        
                            <td style="padding:14px 16px; font-weight:700; text-align:right; border:1px solid #e2e8f0; font-size:15px; color:#2d3748; background:#f7fafc !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Subtotal</td>                                                        
                            <td style="padding:14px 16px; font-weight:700; text-align:center; border:1px solid #e2e8f0; font-size:15px; color:#1a1a1a; background:#f7fafc !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">{{ number_format($quotation->service_contract_amount ?? 0, 2) }}</td>                                                    
                        </tr>                                                
                        <tr>                           
                            <td colspan="2" style="border:1px solid #e2e8f0; border-radius:0 0 0 8px; background:#edf2f7 !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;"></td>                                                        
                            <td style="padding:14px 16px; font-weight:700; text-align:right; border:1px solid #e2e8f0; font-size:16px; color:#2c5282; background:#edf2f7 !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Total</td>                                                        
                            <td style="padding:14px 16px; font-weight:700; text-align:center; border-radius:0 0 8px 0; border:1px solid #e2e8f0; font-size:16px; color:#2c5282; background:#edf2f7 !important; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">{{ number_format($quotation->service_contract_amount ?? 0, 2) }}</td>                                                    
                        </tr>                                            
                    </table>                                                                
                    <table>
                        @if($quotation->support_description && count($quotation->support_description) > 0)                                
                        <tr>                                                            
                            <td style="font-weight: 600; padding: 16px 0; font-size: 15px; color: #2d3748;">- Annual Renewal Charge: {{ number_format($quotation->support_total[0] ?? 0, 2) }}/- Per Year & Per Lab.</td>                                                        
                        </tr>
                        @endif                            
                        <tr>                                                        
                            <td style="font-weight: 700; padding: 12px 0;">Payment Terms:</td>                                                    
                        </tr>
                        @if($quotation->terms_description && count($quotation->terms_description) > 0)                                
                        @foreach($quotation->terms_description as $index => $description)                                    
                        @if(trim($description) !== '')                                        
                        <tr>                                                                   
                            <td style="padding: 8px 25px; font-weight: 500; letter-spacing: 0.8px;">                                                
                                <span style="display: inline-block; width: 8px; height: 8px; background-color: #000; border-radius: 50%; margin-right: 10px;"></span>                                                
                                {{ $description }} - {{ $quotation->terms_completion[$index] ?? 0 }}%                                            
                            </td>                                                                
                        </tr>
                        @endif                               
                        @endforeach                            
                        @endif                        
                    </table>                                    
                </td>                            
                </tr>                        
            </table>                
        </div>
            
    <div class="page-number" style="width:91%;">6 | Page</div>
        
    </div>


    <!-- Page 7 - Payment Partition and Terms -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%;">
            <table style="width: 100%; height: 100%;">
                <tr>
                    <td style="vertical-align: top;">
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">Payment Partition</div>
                        
                        <table class="inner-table" cellspacing="0" style="width:100%; border-collapse: separate; margin-bottom: 20px; border-radius: 8px; overflow:hidden; border:1px solid #ddd;">
                            <tr>
                                <td style="background:#3B86B3 !important; color:white !important; padding:12px 15px; font-size:16px; font-weight:600; text-align:left; border:1px solid #ddd; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Description</td>
                                <td style="background:#3B86B3 !important; color:white !important; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Completion Percentage</td>
                                <td style="background:#3B86B3 !important; color:white !important; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Completion Term</td>
                                <td style="background:#3B86B3 !important; color:white !important; padding:12px 15px; font-size:16px; font-weight:600; text-align:center; border:1px solid #ddd; -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important;">Amount</td>
                            </tr>
                            @if($quotation->terms_description && count($quotation->terms_description) > 0)
                                @foreach($quotation->terms_description as $index => $description)
                                    @if(trim($description) !== '')
                                        <tr>
                                            <td style="padding:12px 15px; text-align:left; border:1px solid #ddd; font-weight:600;">{{ $description }}</td>
                                            <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;">{{ $quotation->terms_completion[$index] ?? '' }}%</td>
                                            <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;">{{ $quotation->completion_terms[$index] ?? '' }}</td>
                                            <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;">{{ number_format($quotation->terms_total[$index] ?? 0, 0) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td style="padding:12px 15px; text-align:left; border:1px solid #ddd; font-weight:600;">ADVANCE</td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;"></td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;"></td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;">50000</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 15px; text-align:left; border:1px solid #ddd; font-weight:600;">ON INSTALLATION</td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;"></td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;"></td>
                                    <td style="padding:12px 15px; text-align:center; border:1px solid #ddd; font-weight:600;">150000</td>
                                </tr>
                            @endif
                        </table>

                        <div style="font-size: 24px; font-weight: 600; margin-bottom: 15px; margin-top: 30px;">Terms & Conditions:</div>
                        
                        <div style="font-size: 16px; line-height: 1.8; margin-left: 20px;">
                            <div style="margin-bottom: 10px;"><strong>1.</strong> Quotation is valid till one week from send date. After the expiration of this period, the Quotation may be subject to changes.</div>
                            <div style="margin-bottom: 10px;"><strong>2.</strong> 18% GST will be extra</div>
                            <div style="margin-bottom: 10px;"><strong>3.</strong> We will deliver the Software in accordance with the specifications and milestones detailed in the Quotation. Any delays in the project timeline will be communicated to the Client promptly.</div>
                            <div style="margin-bottom: 10px;"><strong>4.</strong> The Client agrees to provide all necessary materials, access, and cooperation required for the successful completion of the project. Delays caused by the Client may result in an extension of the project timeline and additional charges.</div>
                            <div style="margin-bottom: 10px;"><strong>5.</strong> Both parties agree to treat any confidential information exchanged during the course of the project as confidential and not to disclose it to third parties.</div>
                            <div style="margin-bottom: 10px;"><strong>6.</strong> This Agreement constitutes the entire understanding between the parties and supersedes any prior agreements or understandings, whether oral or written</div>
                            <div style="margin-bottom: 10px;"><strong>7.</strong> Accommodation charges will be in your scope.</div>
                            <div style="margin-bottom: 10px;"><strong>8.</strong> Payments made are strictly non-refundable. By completing transaction, you agree to these terms without exception.</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%;">7 | Page</div>
    </div>

    <!-- Page 8 - Bank Details and Agreement -->
    <div class="page" style="position: relative;">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%;">
            <table style="width: 100%; height: 100%;">
                <tr>
                    <td style="vertical-align: top;">
                        
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px; background: #3B86B3; color: white; padding: 15px; border-radius: 8px; text-align: center;">Bank Details</div>
                        
                        <table class="modern-table" style="width: 100%; border-collapse: separate; border-radius: 8px; overflow:hidden; border:1px solid #ddd; margin-bottom: 30px;">
                            <tr>
                                <td style="width: 30%; padding: 12px 15px; font-size: 18px; text-align: left; border-right: 1px solid #ddd; font-weight: 800; color: #333; background: #f8f9fa; border-top: 1px solid #ddd;">Account No.</td>
                                <td style="padding: 12px 15px; font-size: 16px; color: #444; text-align: left; font-weight: 600; border-top: 1px solid #ddd; border-left:1px solid #ddd;">001161900016923</td>
                            </tr>
                            <tr>
                                <td style="width: 30%; padding: 12px 15px; font-size: 18px; text-align: left; font-weight: 800; color: #333; background: #f8f9fa; border-top: 1px solid #ddd;">IFSC Code</td>
                                <td style="padding: 12px 15px; font-size: 16px; color: #444; text-align: left; font-weight: 600; border-top: 1px solid #ddd; border-left:1px solid #ddd;">YESB0000011</td>
                            </tr>
                            <tr>
                                <td style="width: 30%; padding: 12px 15px; font-size: 18px; text-align: left; font-weight: 800; color: #333; background: #f8f9fa; border-top: 1px solid #ddd;">Name</td>
                                <td style="padding: 12px 15px; font-size: 16px; color: #444; text-align: left; font-weight: 600; border-top: 1px solid #ddd; border-left:1px solid #ddd;">CHITRI ENLARGE SOFT IT HUB PVT LTD</td>
                            </tr>
                            <tr>
                                <td style="width: 30%; padding: 12px 15px; font-size: 18px; text-align: left; font-weight: 800; color: #333; background: #f8f9fa; border-top: 1px solid #ddd;">Branch</td>
                                <td style="padding: 12px 15px; font-size: 16px; color: #444; text-align: left; font-weight: 600; border-top: 1px solid #ddd; border-left:1px solid #ddd;">YES BANK LTD,GR FLOOR, MANGALDEEP, RING ROAD, NEAR MAHAVIR HOSPITAL, NEAR RTO, SURAT – 395001.</td>
                            </tr>
                        </table>

                        <div style="margin-top:20px;">
                            <div style="font-size:24px; font-weight: 600; margin-bottom: 15px;">Agreement</div>
                            <div style="font-size:20px; line-height:1.8; margin-bottom: 30px;">By signing below, you agree to accept this proposal for {{ $quotation->quotation_title ?? 'Software' }} development and any modifications already agreed upon with {{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}.</div>
                        </div>

                        <table class="inner-table" style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td style="width: 45%; vertical-align: top;">
                                    <div style="background: linear-gradient(to bottom right, #ffffff, #f8f9fa); border-radius: 16px; padding: 2px;">
                                        <div style="background: #3B86B3; border-radius: 15px 15px 0 0; padding: 15px 25px;">
                                            <h3 style="font-size: 20px; color: #ffffff; margin: 0; letter-spacing: 0.5px; font-weight: 600;">{{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)' }}</h3>
                                        </div>
                                        <div style="padding: 25px;">
                                            <div style="margin-bottom: 25px;">
                                                <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Authorized Signatory</label>
                                                <p style="font-size: 19px; color: #2c3e50; margin: 0; font-weight: 600; border-bottom: 2px solid #3B86B3; padding-bottom: 8px; display: inline-block;">MR. {{ $quotation->prepared_by ?? 'CHINTAN KACHHADIYA' }}</p>
                                            </div>
                                            <div style="border: 2px dashed rgb(190, 190, 190); height: 100px; margin: 30px 0; background: rgba(59,134,179,0.03); border-radius: 12px;"></div>
                                            <div style="margin-top: 25px;">
                                                <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Date</label>
                                                <div style="border-bottom: 2px solid #3B86B3; padding: 8px 0;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 10%;"></td>
                                <td style="width: 45%; vertical-align: top;">
                                    <div style="background: linear-gradient(to bottom right, #ffffff, #f8f9fa); border-radius: 16px; padding: 2px;">
                                        <div style="background: #3B86B3; border-radius: 15px 15px 0 0; padding: 15px 25px;">
                                            <h3 style="font-size: 20px; color: #ffffff; margin: 0; letter-spacing: 0.5px; font-weight: 600;">{{ $quotation->company_name }}</h3>
                                        </div>
                                        <div style="padding: 25px;">
                                            <div style="margin-bottom: 25px;">
                                                <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Authorized Signatory</label>
                                                <p style="font-size: 19px; color: #2c3e50; margin: 0; font-weight: 600; border-bottom: 2px solid #3B86B3; padding-bottom: 8px; display: inline-block;">MR. {{ $quotation->contact_person_1 }}</p>
                                            </div>
                                            <div style="border: 2px dashed rgb(190, 190, 190); height: 100px; margin: 30px 0; background: rgba(59,134,179,0.03); border-radius: 12px;"></div>
                                            <div style="margin-top: 25px;">
                                                <label style="display: block; font-size: 15px; color: #555; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Date</label>
                                                <div style="border-bottom: 2px solid #3B86B3; padding: 8px 0;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%;">8 | Page</div>
    </div>

    <!-- Page 9 - Why Choose Us -->
    <div class="page">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.1;">
        </div>

        <div style="position: relative;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 28px; font-weight: 600; margin-bottom: 15px;">✤ Why Choose Us?</div>
                        <div style="font-size: 20px; margin-left: 20px; line-height: 30px; text-align: justify;">
                            <ul style="font-size:17px; font-weight: 500; margin-left:20px; margin-bottom:20px; list-style-type: disc; line-height: 30px;">
                                <li><strong>Expertise and Experience:</strong> With years of experience in the industry, our team of experts brings extensive knowledge and proven methodologies to every project. We understand the unique challenges faced by businesses and are equipped to deliver tailored solutions that meet your specific needs.</li>
                                <li><strong>Customized Solutions:</strong> We believe that every client is unique. Our approach involves closely collaborating with you to understand your goals and challenges, allowing us to create customized software solutions that align perfectly with your business objectives.</li>
                                <li><strong>Commitment to Quality:</strong> Quality is at the forefront of everything we do. We adhere to industry best practices and rigorous testing protocols to ensure that our solutions are not only functional but also reliable, secure, and scalable.</li>
                                <li><strong>Client-Centric Approach:</strong> Your satisfaction is our priority. We maintain open lines of communication throughout the project, providing regular updates and seeking your feedback to ensure that the final product exceeds your expectations.</li>
                                <li><strong>Comprehensive Support:</strong> Our commitment doesn't end with project delivery. We offer ongoing support and maintenance to address any issues that may arise and to help you adapt to evolving business needs, ensuring your software remains effective and relevant.</li>
                                <li><strong>Innovative Technology:</strong> We leverage the latest technologies and tools to provide innovative solutions that enhance efficiency, productivity, and user experience. Our forward-thinking approach ensures that you stay ahead of the competition.</li>
                                <li><strong>Proven Track Record:</strong> We have a history of successful projects and satisfied clients across various industries. Our portfolio showcases our ability to deliver results and drive positive outcomes for businesses like yours.</li>
                                <li><strong>Cost-Effective Solutions:</strong> We understand the importance of budget considerations. Our solutions are designed to provide maximum value, helping you achieve your goals without compromising on quality.</li>
                            </ul>
                        </div>
                        <div style="font-size: 26px; font-weight: 700; margin-bottom: 16px; margin-top: 32px; color: #1a1a1a; letter-spacing: -0.01em;">✤ Next Steps</div>
                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 20px; font-weight: 500; color: #2d3748; text-align: justify;">
                            We look forward to the opportunity to work with you. Please feel free to reach out with any questions or to discuss this proposal further. To proceed, please sign and return this proposal.
                        </div>
                        <div style="font-size: 17px; line-height: 1.8; margin-bottom: 40px; font-weight: 500; color: #2d3748;">
                            Thank you for considering our proposal!
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-number" style="width:91%">9 | Page</div>
    </div>

    <!-- Page 10 - Thank You Page -->
    <div class="page">
        <!-- Background watermark -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Background Logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; opacity: 0.05;">
        </div>

        <!-- Main content -->
        <div style="position: relative; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
            <div style="max-width: 600px; margin: 0 auto;">
                {{-- <!-- Thank You Icon/Image -->
                <div style="margin-bottom: 40px;">
                    <img src="{{ asset('thank-you.png') }}" alt="Thank You" style="width: 200px; height: 200px; margin: 0 auto; display: block;">
                </div> --}}

                <!-- Main Thank You Message -->
                <div style="font-size: 48px; font-weight: 700; color: #3B86B3; margin-bottom: 24px; letter-spacing: -0.02em;">
                    Thank You!
                </div>

                <!-- Subtitle -->
                <div style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin-bottom: 32px; line-height: 1.4;">
                    We appreciate your time and consideration
                </div>

                <!-- Message -->
                <div style="font-size: 17px; line-height: 1.8; color: #2d3748; margin-bottom: 40px; text-align: center;">
                    We are excited about the opportunity to partner with <strong style="color: #1a1a1a;">{{ $quotation->company_name }}</strong> and help transform your vision into reality. Our team is ready to deliver exceptional results that exceed your expectations.
                </div>

                <!-- Contact Information Box -->
                <div style="background: linear-gradient(135deg, #3B86B3 0%, #2c5282 100%); border-radius: 12px; padding: 32px; margin-bottom: 40px; box-shadow: 0 4px 12px rgba(59, 134, 179, 0.2); -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;">
                    <div style="font-size: 20px; font-weight: 700; color: #ffffff; margin-bottom: 20px;">
                        Let's Get Started!
                    </div>
                    <div style="font-size: 16px; color: #ffffff; line-height: 1.8; margin-bottom: 8px;">
                        <strong>Contact Person:</strong> {{ $quotation->prepared_by ?? 'MR. CHINTAN KACHHADIYA' }}
                    </div>
                    <div style="font-size: 16px; color: #ffffff; line-height: 1.8; margin-bottom: 8px;">
                        <strong>Phone:</strong> (+91) {{ $quotation->mobile_no ?? '72763 23999' }}
                    </div>
                    <div style="font-size: 16px; color: #ffffff; line-height: 1.8;">
                        <strong>Company:</strong> {{ $quotation->own_company_name ?? 'CHITRI ENLARGE SOFT IT HUB PVT LTD' }}
                    </div>
                </div>

                <!-- Closing Message -->
                <div style="font-size: 18px; font-weight: 600; color: #3B86B3; font-style: italic;">
                    "Building Tomorrow's Solutions, Today"
                </div>
            </div>
        </div>
        
        <div class="page-number" style="width:91%">10 | Page</div>
    </div>

</body>

</html>