<div class="mb-4">
  <h4>
    Set and Appointment Date and Time of Handover
    <a tabindex="0" class="ml-1" role="button" data-toggle="popover"  data-trigger="focus" style="cursor: pointer"
       data-content="Set an “Appointment Date” and a “Time of Handover” of your Car to your Dealer. Appointments can only be set on weekdays (Monday to Fridays) between 9am to 5pm based on our participating bank(s) / financial institution(s) operating hours."
    >
      <i class="fa fa-info-circle red " ></i>
    </a>
  </h4>



</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Appointment Date </label>
  <div class="col-md-9">
    <div class="text-view"> [[dataForm.AppointmentDate | date : 'dd MMM yyyy']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label">Appointment Time </label>
  <div class="col-md-9">
    <div class="text-view"> [[dataForm.AppointmentTime ]] - [[dataForm.AppointmentTimeTo ]]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label"> Bank Account </label>
  <div class="col-md-9">

    <div class="text-view"> [[dataForm.SellerBankAccount || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label"> Bank </label>
  <div class="col-md-9">

    <div class="text-view"> [[dataForm.BankName || '-']]</div>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-3 col-form-label"> Place </label>
  <div class="col-md-9">

    <div class="text-view"> [[dataForm.AppointmentPlace || '-']]</div>
  </div>
</div>

