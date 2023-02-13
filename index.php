<?php
session_start();
require_once './backoffice/config/db/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $form_data = filter_input_array(INPUT_POST);



    var_dump($form_data);

    $target_dir = "uploads/";
    $photograph = $target_dir . basename($_FILES["photograph"]["name"]);
    $qualification_certificate = $target_dir . basename($_FILES["qualification_certificate"]["name"]);
    $previous_licence = $target_dir . basename($_FILES["previous_licence"]["name"]);

    move_uploaded_file($_FILES["photograph"]["tmp_name"], $photograph);
    move_uploaded_file($_FILES["qualification_certificate"]["tmp_name"], $qualification_certificate);
    move_uploaded_file($_FILES["previous_licence"]["tmp_name"], $previous_licence);

    $data = Array (
        "application" => $form_data['applicant'],
        "qualification_certificate" => $_FILES["qualification_certificate"]["name"],
        "registration_number" => $form_data['registration_number'],
        "previous_licence" => $_FILES["previous_licence"]["name"],
        "photograph"=> $_FILES["photograph"]["name"],
        "aadhar_number"=> null,

    );

    $db = getDbInstance();
    $db->insert ('form_one', $data);

}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSBNSSO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container" id="seedform">
        <div class="topbox">
            <h6>रेशमकीट बीज कोसा उत्पादक</h6>
           <h6> Silkworm Seed Cocoon Producer</h6>
        </div>
       <div class="nextbox">
           <h5><strong>प्ररूप-12 (ग) FORM-12(c)</strong></h5>
           <h6>रेशमकीट बीज कोसा उत्पादक के रूप में रजिस्ट्रीकरण/नवीकरण के लिए ओवदन-पत्र</h6>
           <h6>Application for Registration/Renewal as a Silkworm Seed Cocoon Producer</h6>
           <h6>नियम 47(1) देखें [See rule 47(1)]</h6>
       </div>
        <div class="anotherbox">
            <h6>आवेदन Application</h6>

        </div>
        <form autocomplete="false" class="well form-horizontal" action="" method="post"  id="applicationform" enctype="multipart/form-data">
        <div class="row" style="text-align: center" id="applicant">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="applicant" value="New Applicant" >
                    <label class="form-check-label" for="exampleRadios1">
                        नए आवेदक NEW Applicant
                    </label>
                </div>
                <br>
               <div class="newhideapplicant">
                   <p>
                       शैक्षणिक योग्यता प्रमाण-पत्र की छवि अपलोड करें [न्यूनतम मेट्रिकुलेशन]
                   </p>
                   <p>
                       Upload image of educational qualification certificate
                       (minimum matriculation)
                   </p>
                   <br>
                   <div class="form-group" style="text-align: center; margin: 0 auto; display: inline-block;">
                       <input type="file" class="form-control-file" name="qualification_certificate" id="qualification_certificate">
                   </div>
               </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="applicant" id="applicant2" value="Renewal Applicant" >
                    <label class="form-check-label" for="exampleRadios1">
                        नवीकरण आवेदक RENEWAL Applicant
                    </label>
                </div>
                <br>
                <div class="renewalhideapplicant">
                <div class="row ">
                    <div class="col-md-6">
                        <p>आवेदक का पंजीकरण संख्या</p>
                        <p>Registration number of the applicant</p>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" >

                            <input type="text" class="form-control" name="registration_number" id="registration_number">
                        </div>
                    </div>
                </div>
                    <br>
                <div class="row">
                    <p>पिछले लाइसेंन्स छवि अपलोड करें / Upload image of previous Licence copy</p>


                    <br>
                    <div class="form-group" style="text-align: center; margin: 20px auto; display: inline-block;">

                        <input type="file" class="form-control-file" name="previous_licence" id="previous_licence">
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="passport">
                    <h6>आवेदक का फोटोग्राफं</h6>
                    <h6>Photograph of the Applicant</h6>
                </div>
                <p>पासपोर्ट साइज़ रंगीन फोटोग्राफ अपलोड करें</p>
                <p>Upload passport size colour photograph of the Applicant</p>
                <div class="form-group">
                    <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                </div>
            </div>
            <div class="col-md-7">
                <div class="details">
                    <h6>आवेदक का विवरण</h6>
                    <h6>Applicant Details</h6>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-5">
                        <p>आवेदक का आधार संख्या</p>
                        <p>Aadhaar number of the Applicant</p>
                    </div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <input type="text" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>लैंड लाइन [एसटीडी कोड सहित]</p>
                        <p>Land line (with STD code)</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <input type="text" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>मोबाईल संख्या</p>
                        <p>Mobile number</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <input type="text" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>आवेदक का प्रकार</p>
                        <p>Applicant type</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="applicant" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    राज्य सरकारी State Government
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="applicant" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    केंद्रीय रेशम बोर्ड Central Silk Board
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="applicant" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    गैससं NGOs
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="applicant" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    निजी Private
                                </label>
                            </div>
                        </div>

                    </div>
                    <p>(NOTE: New private/NGOs seed producers should upload their 3months training certificate. Renewal private/NGOs RSPs should upload their refresher training certificate. Failing which application will be subject to rejection.)</p>
                </div>
            </div>
        </div>
            <div class="addressbox"></div>
            <br>
            <div class="row">
                <div class="col-md-5">

                    <p>इकाई का नाम </p>
                    <p>Name of the unit</p>

                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-5">

                <p>गाँव/नगर/शहर जहाँ इकाई स्थित है</p>
                <p>Village/Town/City where the Unit is located</p>

            </div>
                <div class="col-md-1">:</div>
            <div class="col-md-6">
                <div class="form-group">

                    <input type="text" class="form-control" >
                </div>
            </div>
        </div>
            <div class="row">
            <div class="col-md-5">

                <p>डाक पता, कमरा संख्या, गली, गॉव, क्षेत्र/स्थान</p>
                <p>Mailing Address, Door Number, Street, village, Area/locality</p>

            </div>
                <div class="col-md-1">:</div>
            <div class="col-md-6">
                <div class="form-group">

                    <textarea name="" id="" cols="30" rows="6"></textarea>
                </div>
            </div>
        </div>
            <div class="row">
            <div class="col-md-5">

                <p>तालूक</p>
                <p>Taluk</p>

            </div>
                <div class="col-md-1">:</div>
            <div class="col-md-6">
                <div class="form-group">

                    <input type="text" class="form-control" >
                </div>
            </div>
        </div>
            <div class="row">
            <div class="col-md-5">

                <p>जिला </p>
                <p>
                    District
                </p>

            </div>
                <div class="col-md-1">:</div>
            <div class="col-md-6">
                <div class="form-group">

                    <input type="text" class="form-control" >
                </div>
            </div>
        </div>
            <div class="row">
            <div class="col-md-5">

                <p>राज्य</p>
                <p>State</p>

            </div>
                <div class="col-md-1">:</div>
            <div class="col-md-6">
                <div class="form-group">

                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पिनकोड</p>
                    <p>
                        Pin Code
                    </p>

                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>

            <div class="productionbox">
                <h6>बीज उत्पादन केंद्र विवरण </h6>
                <h6>Production Center Details</h6>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">

                    <p>बीज उत्पादन केंद्र का नाम / Name of seed production center</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>बीज उत्पादन केंद्र का पता Production Center Address कमरा संख्या Door Number, गली Street, गॉव village, क्षेत्र/स्थान Area/locality</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">

                    <p>तालूक / Taluk</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>जिला /  District</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>राज्य / State</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पिनकोड /  Pin Code</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>क्षेत्र / Sector</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>उत्पा‍दित किए जाने हेतु प्रस्तावित रेशमकीट बीज की किस्म/उपजाति
                        Kind or variety of silkworm seed proposed to be produced</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>रेशमकीट बीज उत्पादन इकाई की क्षमता / Capacity of the silkworm seed production unit</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>उत्पादित किए जाने हेतु प्रस्तावित रेशमकीट बीज की मात्रा / Quantity of silkworm seed proposed to be produced</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>स्थापना वर्ष / Year of establishment</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>भवन स्वामित्व का प्रकार / Building ownership type</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>इस आवेदन की तारीख को कार्यरत कर्मचारी/कामगारों की संख्या / No. of employees/workers working as on date</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>वर्तमान उत्पादन स्तर (लाखों में) / Present production level (in lakhs)</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>उत्पादन इकाई में उपलब्ध सुविधाएं / Facilities available in the production unit</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>कोई अन्य विवरण / Any other details</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <input type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="otherdoc">
                <h6>कोई अन्य दस्तावेज - ऐच्छिक
                    (एकल पृष्ठ छवि अपलोड करें)</h6>
               <h6> Any other documents - Optional
                   (upload single page image)</h6>
            </div>
            <br>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 1 / Page 1</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 2 / Page 2</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 3 / Page 3</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 4 / Page 4</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 5 / Page 5</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">

                    <p>पृष्ठ 6 / Page 6</p>


                </div>
                <div class="col-md-1">:</div>
                <div class="col-md-6">
                    <div class="form-group">

                        <div class="form-group">
                            <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="declaration">
                <h6>घोषणा</h6>
                <h6>Declaration</h6>
            </div>
            <p>मैं/हम घोषणा करता/करती हूँ/करते हैं कि उपर्युक्त विवरण मेरी/हमारी पूरी जानकारी और विश्वास के अनुसार सत्य और सही है और तत्संबंधी कोई भाग गलत नहीं है ।
                I / We declare that the information given above is true to the best of my / our knowledge and belief and no part thereof is false.</p>
            <div class="form-group">
                <p>हस्ताक्षर छवि अपलोड करें Upload Signature Image of the Applicant</p>
                <input type="file" name="photograph" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>