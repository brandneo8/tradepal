<div class="form-group row">
  <label class="col-md-3 col-form-label">NRIC</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.NRIC || '-']]</div>
  </div>
</div>

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
  <label class="col-md-3 col-form-label">Primary Colour</label>
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
  <label class="col-md-3 col-form-label">VDO</label>
  <div class="col-md-9">
    <div class="video-view" ng-if="dataView.Video">
      <video controls ng-if="dataView.Video">
        <source src="[[CONST.img_host]]/uploads/files/[[dataView.Video]]">
      </video>
    </div>
  </div>
</div>


<div class="form-group row">
  <label class="col-md-3 col-form-label">Car Photo</label>
  <div class="col-md-9">

    <div class="row list-img" id="lightgallery">
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo1]]" class="light-link"  data-sub-html="Car Photo Front">

          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo1 | trustSrc]]" alt="">
            </div>
            <div class="label">Front</div>
          </div>
        </a>

      </div>
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo2]]" class="light-link" data-sub-html="Car Photo Left">
          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo2 | trustSrc]]" alt="">
            </div>
            <div class="label">Left</div>
          </div>
        </a>

      </div>
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo3]]" class="light-link" data-sub-html="Car Photo Right">
          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo3 | trustSrc]]" alt="">
            </div>
            <div class="label">Right</div>
          </div>
        </a>
      </div>
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo4]]" class="light-link" data-sub-html="Car Photo Back">
          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo4 | trustSrc]]" alt="Back">
            </div>
            <div class="label">Back</div>
          </div>
        </a>

      </div>
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo5]]" class="light-link" data-sub-html="Car Interior">
          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo5 | trustSrc]]" alt="">
            </div>
            <div class="label">Interior</div>
          </div>
        </a>
      </div>
      <div class="col-6 col-sm-4 col-md-2">
        <a href="[[CONST.img_host + dataView.Photo6]]" class="light-link" data-sub-html="Car Photo Zoom into mileage">
          <div class="item">
            <div class="img-view">
              <img ng-src="[[CONST.img_host + dataView.Photo6 | trustSrc]]" alt="">
            </div>
            <div class="label">Zoom into mileage</div>
          </div>
        </a>
      </div>
    </div>


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
  <label class="col-md-3 col-form-label">Outstanding hire purchase advance</label>
  <div class="col-md-9">
    
    <div class="text-view"> [[dataView.OutStandingHirePurchaseLoan  == '1' ? 'Yes' : 'No' ]] </div>
  
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Bank</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.Bank || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Balance payable to seller by Dealer</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.BalancePayableToSellerByTrader || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Tentative Delivery Date</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.TentativeDeliveryDate | date : 'dd MMM yyyy' ]]</div>
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

<!--<div class="form-group row">-->
<!--  <label class="col-md-3 col-form-label">Full Settlement </label>-->
<!--  <div class="col-md-9">-->
<!--    <div class="text-view">-->
<!--      <a target="_blank" href="[[CONST.img_host]]/uploads/[[dataView.DocHandoverAcknowledgement]]">View Document</a>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<div class="form-group row">
  <label class="col-md-3 col-form-label">Remark</label>
  <div class="col-md-9">
    <div class="text-view"> [[dataView.Remark || '-']]</div>
  </div>
</div>

