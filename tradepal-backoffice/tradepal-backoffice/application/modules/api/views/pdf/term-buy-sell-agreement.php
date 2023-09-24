<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>AGREEMENT FOR SALE AND PURCHASE</title>
</head>
<body >

<div class="term-e-agreemen">

<table class="table-sub" style="vertical-align: center">
  <tr>
    <td width="100">
      <img src="https://admin.tradepal.sg<?php echo $case->DealerRoot['Logo'] ?>" alt="" style="height: 80px;" class="ng-scope">
    </td>
    <td style="text-align: center; font-size: 16px; padding-right: 100px; padding-top: 25px;" >
     
        <b> AGREEMENT FOR SALE AND PURCHASE </b>
      
    </td>
  </tr>
</table>
<div style="height: 20px"></div>

<table class="tables">
  <tr>
    <td width="200">dated</td>
    <td><?php echo  $case->INS ?></td>
  </tr>
</table>

<div style="height: 20px"></div>
<div class="">and made between</div>
<div style="height: 20px"></div>

<table class="tables">
  <tr>
    <th width="200" style="text-align: left;"><b>Car Owner </b></th>
    <th>Name</th>
    <th>Identification</th>
    <th>Address</th>
  </tr>
  <tr>
    <td></td>
    <td><?php echo $case->Seller['Name'] ?></td>
    <td>
        
        <?php if ($case->Seller['SellerTypeID'] == '1'): ?>
          INDIVIDUAL
        <?php endif; ?>
        <?php if ($case->Seller['SellerTypeID'] == '2'): ?>
          COMPANY
        <?php endif; ?>
        
        <?php echo $case->Seller['IDNo'] ?>
    </td>
    <td><?php echo $case->Seller['BlkHseNo'] ?><?php echo $case->Seller['Street'] ?><?php echo $case->Seller['Unit'] ?><?php echo $case->Seller['BuildingName'] ?><?php echo $case->Seller['PostalCode'] ?></td>
  </tr>
</table>


<div style="height: 20px"></div>
<div class="">and</div>
<div style="height: 20px"></div>


<table class="tables">
  <tr>
    <td width="200"><b>“Dealer”</b></td>
    <td><?php echo $case->DealerRoot['CompanyName'] ?></td>
  </tr>
</table>


<div style="height: 20px"></div>
<div class="">for the sale of by the Seller and the purchase by the Dealer of</div>
<div style="height: 20px"></div>


<table class="tables">
  <tr>
    <td width="200"><b>“Vehicle” </b></td>
    <td>

      <table class="table-sub">
        <tr>
          <td width="100"></td>
          <td width="300"></td>
        </tr>
        <tr>
          <td class="label">Vehicle ID</td>
          <td class="value"><?php echo $case->VehicleNo ?></td>

        </tr>
        <tr>
          <td class="label">Chassis No.</td>
          <td class="value"><?php echo $case->ChassisNo ?></td>

        </tr>
        <tr>
          <td class="label">Make & Model</td>
          <td class="value"><?php echo $case->VehicleMake ?><?php echo $case->VehicleModel ?></td>

        </tr>
        <tr>
          <td class="label">Registration Date</td>
          <td class="value"><?php echo $case->OriginalRegnDate ?></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>

      </table>
    </td>
  </tr>
</table>


<div style="height: 20px"></div>
<div class="">as</div>
<div style="height: 20px"></div>

<table class="tables">
  <tr>
    <td width="200"><b>“the Sale Price” </b></td>
    <td>
        <?php echo $case->PriceAgreed ?> :
      <br> <br>
      (1) *inclusive / *exclusive of GST *To delete if not applicable.
      <br> <br>
      (2) inclusive of the sum of <?php echo $case->BalancePayableToSellerByTrader ?> payable by the Dealer to the Seller on
      or before the date of this Agreement
    </td>
  </tr>
</table>
<div style="height: 20px"></div>


<table class="tables">
  <tr>
    <td width="200"><b>“the Delivery Time and Date” </b></td>
    <td>
      for delivery of the Vehicle by the Seller to the Dealer at
        
        <?php echo $case->TentativeDeliveryDate ?>
    </td>
  </tr>
</table>

<div style="height: 20px"></div>

<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b>1</b></td>
    <td>
      The Seller agrees to sell and the Dealer agrees to purchase the Vehicle,
      free from all encumbrances of whatsoever nature, at the Sale Price as
      described above and upon these terms and conditions. Any deletion of,
      addition to or other variation of such description or these terms and
      conditions are not applicable unless accepted in writing by the Dealer.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>No variation</i></b>
    </td>
  </tr>
</table>

<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 2 </b></td>
    <td>
      The Dealer shall not be liable under any circumstances whatsoever to
      pay to the Seller more than the Sale Price for the purchase of the
      Vehicle.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>Not more than
          Sale Price</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 3 </b></td>
    <td>
      The Seller declares, represent and warrants that as at the date of this
      Agreement and until completion of the sale of the Vehicle:

      <br><br>
      (1) the Seller is the only legal and beneficial of the Vehicle and that it
      has full legal capacity and power to transfer and vest the full legal
      and beneficial ownership and title of the Vehicle to the Dealer;
      <br><br>
      (2) the Seller has provided the Dealer with complete and correct
      information relating to the Seller and the Vehicle which may affect
      the Dealer’s decision on whether to purchase the Vehicle or on the
      <br><br>
      price or terms and conditions of purchase of the Vehicle;
      (3) all representations made by the Seller orally or in writing or in any
      other form in relation to the Vehicle are true and accurate;
      <br><br>
      (4) the Vehicle is of merchantable quality and free from any defects
      latent or otherwise; and
      <br><br>
      (5) all additions or modifications (if any) of the Vehicle were done with
      proper skill and care and with all necessary approvals of the relevant
      authorities.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>

          Seller’s
          declarations,
          representations
          and warranties
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 4</b></td>
    <td>
      The Delivery Time and Date is of the essence of this Agreement. At the
      Delivery Time and Date, the Seller shall deliver the Vehicle to the Dealer
      in the same condition as the Vehicle was in at the date of signing of this
      Agreement.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Delivery
          condition and
          time and date.
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 5 </b></td>
    <td>
      If:
      <br><br>
      (1) any of such declarations, representations or warranties is found not
      to be true and/or accurate; or

      <br><br>
      (2) the Dealer is of the opinion that the Vehicle is not in such same
      condition
      <br><br>
      the Dealer shall be entitled to rescind this Agreement and to recover all
      monies paid by the Dealer under or in relation to this Agreement,
      without prejudice to any other remedies which the Dealer may have
      against the Seller
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Rescission and
          recovery of
          monies by
          Dealer
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 6 </b></td>
    <td>
      If the Dealer chooses to take delivery of the Vehicle notwithstanding
      delay caused or contributed by the Seller, the Seller shall pay to the
      Dealer the sum computed at the rate of % of the Sale Price
      per day or part thereof as and by way of liquidated damages.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Liquidated
          damages
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 7 </b></td>
    <td>
      On or before delivery of the Vehicle by the Seller to the Dealer, the
      Seller shall apply to the Land Transport Authority of Singapore to
      irrevocably register and authorise only the Dealer as the electronic
      service agent of the Seller, as the Dealer may consider necessary or
      desirable, within the meaning and for the purposes of the Land
      Transport Authority (Electronic Service System) Rules 2019 (as may be
      modified, re-enacted or otherwise replaced from time to time).
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Electronic
          Service Agent
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 8 </b></td>
    <td>
      In the event of any breach by the Seller of any term or condition of this
      Agreement, the Dealer shall be entitled to recover from the Seller all
      losses, damages, costs (including legal costs) and expenses on a full
      indemnity basis suffered or incurred by the Dealer due to or arising from
      such breach.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Recovery of
          Dealer’s losses,
          damages, costs
          and expenses
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 9 </b></td>
    <td>
      Notwithstanding anything herein, the Dealer shall not be liable for any
      loss or damage of property or economic losses or personal injury or
      death:
      <br><br>
      (1) suffered by the Seller arising from any delay or failure of the Dealer
      to perform its obligations under this Agreement due to any reason
      beyond the reasonable control of the Dealer or its employees,
      agents or contractors; or
      <br><br>
      (2) which are the subject of any claim by any third party against the
      Dealer arising from any failure of the Seller to perform and observe
      its obligations under this Agreement or from any reason beyond the
      reasonable control of the Dealer or its employees, agents or
      contractors
      <br><br>
      and the Seller shall fully indemnify the Dealer and its employees, agents
      and contractors against such loss, damage, injury death, claim and costs
      (including legal costs) and expenses on a full indemnity basis suffered or
      incurred by the Dealer due to or arising from such delay or failure or
      claim.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Liability and
          indemnity
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 10</b></td>
    <td>
      The Dealer may terminate this Agreement if the Dealer considers that
      the Seller has failed to observe and perform its obligations under this
      Agreement or may or has contravened any applicable law, without
      prejudice to the Dealer’s rights and remedies in relation to any
      antecedent failure or contravention.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Termination
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 11 </b></td>
    <td>
      The Seller may not, without the prior written approval of the Dealer,
      reproduce or disclose to any third party nor use for the benefit of any
      third party, any information provided by the Dealer or its employees,
      agents or contractors which is not lawfully in the public domain.
    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Confidential
        </i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 12</b></td>
    <td>
      The Seller shall at all times provide and procure all necessary consents in
      writing to provide the Dealer with up to date data about the Seller that
      the Dealer may require for the purposes of this Agreement, including the
      Seller’s name, identification document, nationality, address, telephone
      number, credit or debit card details, race, gender, date of birth, email
      address and any other information about the Seller (“Personal Data”),
      and the Seller hereby:
      <br><br>
      (1) agrees and consents to the Dealer and its employees, agents,
      contractors and financiers collecting, processing and using Personal
      Data for the purposes of this Agreement and for the business and
      activities of the Dealer and its partners, sponsors (including for
      marketing, business or any other purposes) and financiers and to
      fulfil any legal obligation of the Dealer, as well as for the following
      purposes -
      <br><br>
      <div style="padding-left: 10px;">
        (a) to exercise the Dealer’s rights and to perform the Dealer’s
        obligations under this Agreement;
        <br><br>
        (b) to develop, operate and enhance the services and facilities
        provided by the Dealer;
        <br><br>
        (c) to notify, invite and/or consider the participation of the Seller in
        any event, promotion, activity, focus group, research study,
        contest, promotion, poll, survey or any production and to
        communicate with the Seller regarding its attendance thereat;
        and
      </div>

      <br><br>
      (2) agrees and acknowledges that the Dealer and its employ
    </td>
    <td width="150" style="text-align: right;">
      <b><i>Personal data</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b>13 </b></td>
    <td>
      The Dealer and the Company shall comply with their obligations under
      all applicable laws.

    </td>
    <td width="150" style="text-align: right;">
      <b><i> Applicable law</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 14</b></td>
    <td>
      The Seller acknowledges that the Dealer has received or may receive
      advances from a third party (“the Financier”) in relation to the Dealer’s
      purchase of the Vehicle, and accordingly, the Seller hereby irrevocably
      consents to the Dealer’s novation, assignment or other form of transfer
      of the Dealer’s rights and obligations under this Agreement to the
      Financier pursuant to the terms and conditions of the agreement
      between the Dealer and the Financier. In event of such novation,
      assignment or other form of transfer, the expression “the Dealer” used
      in this Agreement shall then refer to the Financier. The Seller shall not
      but the Dealer may novate, assign or otherwise transfer any of its rights
      or obligations arising under this Agreement without the prior consent of
      the Seller. Save as provided above, a person who is not a party to these
      terms and conditions shall have no right under the Contracts (Rights of
      Third Parties) Act (Chap 53B) to enforce any provision of the Act.

    </td>
    <td width="150" style="text-align: right;">
      <b><i> Assignment and
          third parties</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 15</b></td>
    <td>
      If any provision of this Agreement shall be adjudged by any court of
      competent jurisdiction to be unlawful, void or unenforceable, such
      provision shall to the extent required to be severed from this Agreement
      and rendered ineffective as far as possible without modifying the
      remaining provisions of this Agreement and shall not in any way affect
      the validity or enforceability of this Agreement.

    </td>
    <td width="150" style="text-align: right;">
      <b><i> Severability</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b>16 </b></td>
    <td>
      Any delay or failure of the Dealer to enforce any term or condition of this
      Agreement shall not constitute a waiver of such term or condition.

    </td>
    <td width="150" style="text-align: right;">
      <b><i>Waiver</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 17</b></td>
    <td>
      All matters related to or arising from these terms and conditions will be
      interpreted and governed by Singapore law and subject to the exclusive
      jurisdiction of the courts of Singapore.

    </td>
    <td width="150" style="text-align: right;">
      <b><i>Law and
          jurisdiction</i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> </b></td>
    <td>

    </td>
    <td width="150" style="text-align: right;">
      <b><i></i></b>
    </td>
  </tr>
</table>


<table style="margin-bottom: 20px;">
  <tr>
    <td width="50"><b> 18</b></td>
    <td>
      The Seller and the Dealer shall endeavour to resolve any dispute
      between them arising out of or in connection with this Agreement
      and/or any related agreements through friendly consultation. If no
      mutually satisfactory resolution can be reached within reasonable time,
      the Dealer may choose to refer the dispute on an exclusive basis for
      mediation in the Singapore Mediation Centre or for final resolution by
      arbitration in Singapore in accordance with the Arbitration Rules of the
      Singapore International Arbitration Centre for the time being in force
      which rules are deemed to be incorporated by reference into this provision.

    </td>
    <td width="150" style="text-align: right;">
      <b><i>
          Dispute
          resolution
        </i></b>
    </td>
  </tr>
</table>
<div style="height: 50px"></div>

<table style="margin-bottom: 20px; width: 100%">
  <tr>
    <td width="50%">
      Signed
      <br><br> <br><br> <br><br>
      by <?php echo $case->Seller['Name'] ?> <br>
      as the Seller
    </td>
    <td width="50%">
      Signed
      <br><br> <br><br> <br><br>
      by <?php echo $case->DealerRoot['CompanyName'] ?><br>

      for and on behalf of<br>

    </td>

  </tr>
</table>
</div>

</body>
</html>

