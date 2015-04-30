/**
 * fortunor functions
 * \author ck
 */
Fortunor.prototype = {
  payment_: null,
  freelotto_: null,
  
  /**
  * Events
  */
  onsubmitfailed: function(){},
  onsubmitsucceeded: function(){},
  
  /**
  * Submit freelotto
  */
  submit: function() {
      // Build parameters for get
      var params = {
        reference: this.payment_.uniqueid_, 
      };
      
      $.get(
        "lottery.php",
        params,
        function(data) {
          if (!!data.error) {
              alert(data.error);
              this.onsubmitfailed();
              return ;
          }
          
          this.onsubmitsucceeded(data);
        }.bind(this),
        "json"
      );
  },
};

/**
* ctor for fortunor with payment and freelotto instance
* \param Payment payment
* \param Freelotto freelotto
*/
function Fortunor(payment) {
  this.payment_ = payment;
}
