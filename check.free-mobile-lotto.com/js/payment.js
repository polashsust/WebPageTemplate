/**
 * payment functions
 * \author ck
 */

Payment.prototype = {
  /**
  * Data for this particular payment session
  */
  uniqueid_: null,  //< UniqueID of the payment, pr. b. PI
  shortid_: null,  //< ShortID of the payment
  qrcode_: null,  //< URL to the QR-Code
  appurl_: null,  //< URL to the application
  descriptor_: null, //< Payment descriptor for the initial VA.QP
  laststate_: null,  //< Last state
  transaction_: false,

  /**
  * Store the last error that occurred, if any.
  */
  lasterror_: null,  //< string rep.
  pollhandle_: null,

  /**
  * Events
  */
  ontransactionallocation: function(){},
  ontransactionallocationfailed: function(){},
  onpay: function(){},
  onpayfailed: function(){},
  onpaymentsucceeded: function(){},
  onpaymentfailed: function(){},
  onpollfailed: function(){},

  /**
  * Triggered on payment state change
  * \param string nextstate
  */
  onpaymentstatechange: function(nextstate){
    if (['RECEIVED'].indexOf(nextstate) >= 0) {
      this.stopPollingLoop();
      this.onpaymentsucceeded();
    }
    else if (nextstate == 'ERROR') {
      this.stopPollingLoop();
      this.onpaymentfailed();
    }
  },

  /**
  * Allocate a new transaction by means of GET request to the
  * server-side payment interface API client.
  * \param Freelotto freelotto
  */
  allocateTransaction: function() {
    if (this.transaction_) {
      return;
    }
    
    this.transaction_ = true;
    $.get(
      "qrcode.php",
      function(data) {
        if (!!data.error) {
          this.lasterror_ = data.error;
          this.ontransactionallocationfailed();
          return ;
        }

        this.lasterror_ = null;
        this.qrcode_ = data.qrcode;
        this.appurl_ = data.appurl;
        this.descriptor_ = data.descriptor;
        this.shortid_ = data.shortid;
        this.uniqueid_ = data.uniqueid;
        this.ontransactionallocation();
      }.bind(this),
      "json"
    );
  },
  
  /**
  * Pay and transmit numbers
  * \param Freelotto freelotto
  */
  pay: function(freelotto) {
    $.get(
      "pay.php",
      {
        "digits": freelotto.numbers_,
        "reference": this.uniqueid_
      },
      function(data) {
        if (!!data.error) {
          this.lasterror_ = data.error;
          this.onpayfailed();
          return ;
        }

        this.lasterror_ = null;
        this.onpay();
        this.initPollingLoop();
      }.bind(this),
      "json"
    );
  },
  
  /**
  * Check if qr code is set
  */
  checkQrCode: function() {
      return (this.qrcode_ !== null) ? true : false;
  },

  /**
  * Re-initialize with a new unique-id.  Causes a polling
  * loop.
  * \param string uniqueid
  */
  initUniqueId: function(uniqueid) {
    this.uniqueid_ = uniqueid;

    // Allow some time to pass to set up events
    setTimeout(this.initPollingLoop.bind(this), 200);
  },

  /**
  * Begin polling loop
  */
  initPollingLoop: function(){
    this.pollhandle_ = setInterval(this.pollOnce.bind(this), 500);
  },

  /**
  * Quit polling loop
  */
  stopPollingLoop: function(){
    this.pollhandle_ && clearInterval(this.pollhandle_);
  },

  /**
  * Poll the payment status exactly once
  */
  pollOnce: function(){
    $.get(
      "poll.php",
      {
        reference: this.uniqueid_
      },
      function(data) {
        if (!!data.error) {
          this.lasterror_ = data.error;
          this.onpollfailed();
          this.stopPollingLoop();
          return ;
        }

        this.lasterror_ = null;

        if (data.status != this.laststate_) {
          this.onpaymentstatechange(data.status);
          this.laststate_ = data.status;
        }
      }.bind(this),
      "json"
    );
  }
}

/**
* ctor
* \param string uniqueid (optional)
*/
function Payment() {
}