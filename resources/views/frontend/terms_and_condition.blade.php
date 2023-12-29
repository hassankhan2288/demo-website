@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')

<!-- Breadcrumbs -->
<div class="w-full bg-[#ce1212]/10 py-[15px]">
    <div class="!container px-6 mx-auto">
        <div class="flex items-center">
            <div class="grow">
                <nav>
                    <ol class="flex items-center">
                        <li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
                        <li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Terms & Conditions</li>
                    </ol>
                </nav>
            </div>
            <div class="grow text-right">
                <h2 class="text-[16px] font-bold">Terms & Conditions</h2>
            </div>
        </div>
    </div>
</div>

<!-- Shopping Cart -->
<section class="py-[40px]">
    <div class="text-center custom_width mx-auto">
        <div class=" mb-4 text-center ">
            <h1 class="text-[30px] font-bold" >Terms & Conditions</h1>
        </div>
        <div class="terms_content">
            <div class="text-left mb-5 mini_section" id="proceduresAndPolicies">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Procedures & Policies</strong></h1>
                </div>
                <div class="mb-1">
                    <h4 class="mb-2"><strong>These terms and conditions define the following terms:</strong></h4>
                    <p>•	'The company' refers to Cater Choice Limited, its subsidiary companies, associated companies, and holding company. The company is registered in England and Wales under number 03665746 and has its Registered Office at Neville Road, Bradford, West Yorkshire, (BD4 8TU).</p>
                    <p>•	'The customer' refers to any legal entity that purchases products from the company or accepts a quotation from the company for the sale of goods. The term includes the employees, agents, or sub-contractors of any such entity.</p>
                    <p>•	'Goods' refers to any food, beverage, or non-food items that the company is to supply in accordance with these conditions.</p>
                    <p>•	'Contract' refers to any agreement for the purchase and sale of goods.</p>
                    <p>•	'Conditions' refer to the standard terms and conditions of sale outlined in this document, including any special terms and conditions agreed in writing between the customer and the company.</p>
                    <p>•	'Writing' includes communication by facsimile transmission, electronic mail, letters sent by registered mail, or other means of communication.</p>
                    <p>•	'Statutory Interest' refers to interest as defined in the Late Payment of Commercial Debts (Interest) Act 1998.</p>
                    <p>•	 Any mention of a statute in these conditions should be interpreted as a reference to that statute as amended, re-enacted, or extended at the relevant time.</p>
                    <p>•	The headings used in these conditions are for convenience purposes only and do not affect their interpretation.</p>
                    <p>•	These terms and conditions will be part of the contract and will replace and take precedence over any terms and conditions that are communicated verbally or implied by custom or practice. The company has the right to change or update these terms and conditions, and any such changes will become effective when they are posted on the company's website.</p>
                </div>
            </div>
            <div class="text-left mb-5 mini_section" id="orderPlacementPolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Order Placement Policy.</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	When a customer places an order with the company through telesales, salesperson, counter staff, or the website, they are offering to enter into a contract with the company based on these terms and conditions.</p>
                    <p>•	The contract is subject to the availability of goods and market conditions. If a particular item is not available, we may offer a reasonable substitute, and if we're unable to supply an item for reasons beyond our control, we won't be liable for any direct, indirect, consequential, or other losses arising from non-supply.</p>
                    <p>•	The company may, at its discretion and without giving a reason, limit the quantity of goods supplied to a customer, and although we will try to fulfill all orders, large quantity orders can only be fulfilled at our discretion.</p>
                    <p>•	The company has the right to refuse an order, terminate a customer's trading account without notice, or refuse to deliver an order valued less than the minimum order value published in the company's catalogue and website. Abusive or threatening behavior towards staff will result in instant and permanent account termination.</p>
                    <p>•	The quantity, quality, and description of goods will be as stated in the company's quotation or the customer's order, and the contract between the parties will be binding once the company accepts the order or delivers the goods, whichever occurs earlier.</p>
                    <p>•	Any errors or omissions in sales literature, quotation, price list, invoice, or other documents issued by the company will be corrected without liability on the part of the company.</p>
                    <p>•	The company's employees can make representations about goods subject to written confirmation by the company, and the customer acknowledges that they don't rely on any representations not confirmed in writing.</p>
                    <p>•	It's the customer's responsibility to ensure the company receives their order, and the company won't be liable if the order isn't received due to the customer not being contacted, system failure, or any other reason.</p>
                </div>
            </div>
            <div class="text-left mb-5 mini_section" id="deliveryPolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Delivery Policy</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	The terms and conditions outlined in this excerpt relate to the delivery of goods by a company to its customers. </p>
                    <p>•	The delivery of goods should be made in accordance with the customer's delivery schedule. However, the company cannot guarantee that delivery will always take place within the customer's requested timing schedule .</p>
                    <p>•	In addition, the company will not be held liable for any loss or damage arising from the failure to deliver goods on a particular date/time, or as a result of any causes beyond the company's control </p>
                    <p>•	The customer is responsible for ensuring that staff are available to accept delivery during the requested timing schedule, and if the customer chooses to pay cash on delivery, they must ensure that the cash is ready for the driver as soon as they arrive</p>
                    <p>•	If there is no cash for the driver, the company may return the goods to the branch and change the payment method to online only.</p>
                    <p>•	The delivery of goods will be made to reasonably accessible premises as specified by the customer when the account was opened (unless specified in writing), and the company reserves the right to refuse to make deliveries to premises where there is a risk of injury to its employees.</p>
                    <p>•	The customer has the right to limit deliveries to specific areas, and this includes the option to exclude certain areas from the delivery schedule altogether.</p>
                    <p>•	To facilitate the delivery of goods, the customer must ensure that a responsible person is present at the premises to sign for the goods, and provide reasonable access to the premises.</p>
                    <p>•	If the customer fails to provide adequate delivery instructions, or fails to take delivery of the goods for any reason, the company may charge the customer for the cost of delivery to and from the premises, full cost price of perishable goods, a re-scheduling delivery charge, and the company's administration and re-stocking charges.</p>
                    <p>•	The customer must inspect the goods at the time of delivery in the presence of the company's driver, and report any shortages to the driver. The delivery note/invoice will be amended accordingly, and the customer must sign it to confirm receipt of the goods and highlight any shortages.</p>
                    <p>•	If the company fails to deliver the goods for any reason other than any cause beyond its control or the customer's fault, the company's liability will be limited to the cost to the customer of similar goods to replace those not delivered, in the cheapest available market.</p>
                    <p>•	The return policy of the company states that fresh and frozen goods cannot be returned. However, the company may consider accepting the return of other items in good condition and in their original unopened packaging within 14 days of delivery or collection. </p>
                    <p>•	The refund will be issued in the same payment method as the original charge. In case of any product quality issues, the company must be notified within 24 hours of delivery, and evidence must be provided.</p>
                    <p>•	The company reserves the right to investigate the matter and may ask for photographic evidence and batch details. </p>
                    <p>•	The customer must inspect the products upon delivery and notify the driver of any damages or issues. In case of any issues with the quality of the products, the customer must report within 24 hours of delivery. </p>
                    <p>•	The company shall not be liable for any loss arising from or in connection with unsatisfactory goods. In case of collection of goods from the company's warehouse, any damages, shortages, or mistakes must be reported before leaving the premises.</p>
                    <p>•	The company does not accept returns of products ordered under Cater Choice Advance Order, and no credit or refund will be given in such cases.</p>
                </div>
                
            </div>

            <div class="text-left mb-5 mini_section" id="pricePolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Price Policy</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	The invoice price provided by the company will be the cost of the goods. </p>
                    <p>•	The availability of any offers or promotions is subject to change and the company may choose to exclude certain customer groups from these offers, such as wholesalers or contractors. </p>
                    <p>•	The company retains the right to modify product specifications and pricing without notice. Advance orders containing catch weight products may experience price fluctuations.</p>
                    <p>•	The price listed does not include Value Added Tax, which the customer will be responsible for paying. Advance orders containing catch weight products may experience price fluctuations. </p>
                    <p>•	Promotional prices displayed on the branch showroom TV's and emailed are only valid for online orders. Additional offers may require prepayment by card.</p>
                    <p>•	The company reserves the right to apply a fee for delivery orders.</p>
                    <p>•	The customer assumes all responsibility for any damage or loss of goods upon delivery to their premises. </p>
                    <p>•	However, ownership of the goods will not transfer to the customer until full payment has been received by the company for the goods and any other outstanding payments owed for goods sold to the customer.</p>
                    <p>•	In the event that the goods have not been resold and are still in existence, the company retains the right to demand that the goods be returned to them. </p>
                    <p>•	If the customer fails to comply with this request, the company may enter the premises where the goods are being held and reclaim them.</p>
                    
                </div>
                
            </div>

            <div class="text-left mb-5 mini_section" id="warrantyPolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Warranty Policy</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	At the time of delivery, the company guarantees that the goods will match the description and will not have any significant defects in quality and condition until the expiration of the goods' shelf life, which will be indicated on the goods or packaging.</p>
                    <p>•	Furthermore, the company warrants that all food products will adhere to the Food Safety Act 1990 (as amended) and all other goods will comply with all applicable UK and EU regulations that are currently in effect.</p>
                    <p>•	If the company is delayed in fulfilling or fails to fulfill any of its obligations in relation to the goods, the company will not be held liable or considered to have breached the contract if the delay or failure was caused by factors beyond the company's control.</p>
                    
                </div>
                
            </div>

            <div class="text-left mb-5 mini_section" id="paymentPolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Payment Policy</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	Unless agreed otherwise, all new accounts require payment upon delivery or collection, and payment can be made by cash, credit card, debit card, or Pay By Bank.</p>
                    <p>•	Customers have the option to settle their accounts with a Debit Card, Credit Card, or Pay by Bank. </p>
                    <p>•	Customers may apply for a credit account after trading with the company for at least three months. The company will make a decision on whether to open a credit account based on suitable references and cross-references with a Credit Agency. Until a favorable decision is made, payment must be made upon delivery. </p>
                    <p>•	The terms of a credit account require payment of all invoices for one calendar month to be made on the 15th day of the following month. For example, all January invoices are due for payment on the 15th of February</p>
                    <p>•	Customers must settle all accounts according to the agreed terms. If a customer's account is in arrears, the account will be put on hold, and the company reserves the right to withhold further deliveries of goods. </p>
                    <p>•	The company has the right to initiate legal proceedings to recover any outstanding amounts without prior notice and the right to exchange information with credit agencies. </p>
                    <p>•	If payment due to the company is dishonored, a fee of ₤30 (or an amount advised by the company from time to time) will be charged to the customer's account to cover bank and administrative costs.</p>
                    <p>•	If payment due to the company is dishonored, the customer's terms will change to payment upon delivery, and the account will be put on hold until cleared funds are received in full to settle the outstanding balance. </p>
                    <p>•	Late or non-payment of a credit account will be considered a breach of the agreed terms and will render the Credit Terms null and void. The customer's account will be put on hold. </p>
                    <p>•	If non-payment occurs, the company reserves the right to charge Statutory Interest on overdue balances from the date on which the payment was due.</p>
                    <p>•	The company offers multiple payment options including cash, credit card, debit card, Pay by Bank, Cheque, banker's draft, bank transfer, CHAPS, or BACS. </p>
                    <p>•	In the case of certain business cards, also known as corporate or commercial cards, the company reserves the right to charge a fee. </p>
                    <p>•	The maximum amount of cash that will be accepted by the company is £8,500. </p>
                    <p>•	The company only allows a maximum cash payment by coins of £60 in £1 or £2 coins.</p>
                </div>
                
            </div>

            <div class="text-left mb-5 mini_section" id="privacyPolicy">
                <div class="mb-3">
                    <h1 class="text-[20px]"><strong>Privacy Policy</strong></h1>
                </div>
                <div class="mb-1">
                    <p>•	Upon registration on the company's online platform, the customer is required to create a password. It is the customer's responsibility to keep this password confidential, as any orders placed or information provided to the company using the customer's email address and password will be considered authorized. If the customer becomes aware of any unauthorized use of their email address or password, or any breach of security, they must notify the company immediately. </p>
                    <p>•	The company will not share the customer's personal information with any third party for unsolicited marketing or advertising purposes.</p>
                    <p>•	The company has a zero-tolerance policy towards any abusive behavior towards its staff and reserves the right to refuse service or delivery to individuals who exhibit such behavior. Telephone calls may be recorded for training or reference purposes</p>
                    <p>•	The company also reserves the right to refuse entry to its premises at any time, and all visitors must follow company directives for entry and parking, with full acknowledgement of associated risks. </p>
                    <p>•	Children are welcome but must be accompanied by an adult and kept under strict control. Smoking is strictly prohibited on company premises, and only guide dogs are allowed. Additionally, for security reasons, the company may ask for identification before releasing an order.</p>
                </div>
                   
            </div>
        </div>
    </div>
</section>

	
@endsection