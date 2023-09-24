

<div class="form-group row">
  <label class="col-md-3 col-form-label">VehicleNo</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.VehicleNo || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Original Regn Date</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.OriginalRegnDate | date : 'dd MMM yyyy' ]]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Year of Manufacture</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.YearOfManufacture || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Vehicle Make</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.VehicleMake || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Vehicle Model</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.VehicleModel || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Original Colour</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.PrimaryColour || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Chassis No.</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.ChassisNo || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Engine No.</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.EngineNo || '-']]</div>
  </div>
</div>


<div class="form-group row">
  <label class="col-md-3 col-form-label">NRIC</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.NRIC || '-']]</div>
  </div>
</div>


<div class="form-group row">
  <label class="col-md-3 col-form-label">Price Agreed</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.PriceAgreed | number: 2 ]]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Deposit</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.DepositAmount | number : 2 ]]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Need hire purchase advance</label>
  <div class="col-md-9">
 
    <div class="text-view"> [[dataView.SellHirePurchaseLoan == '1' ? 'Yes' : 'No']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Which Bank/Finance Company</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.SellBankFinanceCompany || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">How Much?</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.SellHowMuchHirePurchaseLoan || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Balance payable to Dealer</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.SellBalancePayableToDealer || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Tentative Handovel Date</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.SellTentativeHandOverDate | date : 'dd MMM yyyy' ]]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Change Reg No</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.ChangeRegNo  == '1' ? 'Yes' : 'No']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Registration No</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.RegNo || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Remark</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.Remark || '-']]</div>
  </div>
</div>

