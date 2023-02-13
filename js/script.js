$(document).ready(function (){


    $('input[type=radio][name=applicant]').change(function() {
        if (this.value == 'New Applicant') {
            $('.newhideapplicant').show()
            $('.renewalhideapplicant').hide()
        }
        else if (this.value == 'Renewal Applicant') {
            $('.newhideapplicant').hide()
            $('.renewalhideapplicant').show()
        }
    });

})