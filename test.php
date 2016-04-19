<?php
    //     $url = 'https://www.ipayafrica.com/payments/';

    //     $pst = array();
    // $pst['live'] = 0;
    // $pst['mm'] = 1;
    // $pst['mb'] = 1;
    // $pst['dc'] = 0;
    // $pst['cc'] = 1;
    // $pst['mer'] = 'demo';
    // // $pst['last_name'] = $lastname;
    // $pst['oid'] = '15';
    // $pst['inv'] = '15';
    // $pst['ttl'] = '2000.00';
    // $pst['tel'] = '0770221268';


    // $pst['eml'] = 'kiarie@ipayafrica.com';
    // $pst['vid'] = 'demo';
    // $pst['cur'] = 'KES';
    // $pst['p1'] = '';
    // $pst['p2'] = '';
    // $pst['p3'] = '';
    // $pst['p4'] = '';
    // $pst['cbk'] = 'http://cheapdomain.co.ke/modules/gateways/callback/ipay.php';
    // $pst['cst'] = $pst['eml'];
    // $pst['crl'] = 0;
    // $datastrings = '';
    // foreach ($pst as $key => $value) {
    //     $datastrings .= $value;
    // }
     $datastring = "01101demo15152000.000770221268kiarie@ipayafrica.comdemoKEShttp://cheapdomain.co.ke/modules/gateways/callback/ipay.phpkiarieipayafricacom0";
    // $datastring =  $pst['live'].$pst['mm'].$pst['mb'].$pst['dc'].$pst['cc'].$pst['mer'].$pst['oid'].$pst['inv'].$pst['ttl'].$pst['tel'].$pst['eml'].$pst['vid'].$pst['cur'].$pst['p1'].$pst['p2'].$pst['p3'].$pst['p4'].$pst['cbk'].$pst['cst'].$pst['crl'];
                                                            // $live.$mm.$mb.$dc.$cc.$mer.$oid.$inv.$ttl.$tel.$eml.$vid.$cur.$p1.$p2.$p3.$p4.$cbk.$cst.$crl;

//     $pst['hsh'] = 'demo';
// echo $datastrings.'<br>';
//  echo hash_hmac('sha1', $datastrings, 'demo');
$success = true;
if($success ===true)
{echo "ni true";}
else{echo "si true";}



		?>
                            <form method="post" action="https://www.ipayafrica.com/payments/">
                            	<input type="hidden" name="live" value="0" />
                            	<input type="hidden" name="mm" value="1" />
                            	<input type="hidden" name="mb" value="1" />
                            	<input type="hidden" name="dc" value="0" />
                            	<input type="hidden" name="cc" value="1" />
                            	<input type="hidden" name="mer" value="demo" />
                            	<input type="hidden" name="inv" value="15" />
                            	<input type="hidden" name="oid" value="15" />
                            	<input type="hidden" name="ttl" value="2000.00" />
                            	<input type="hidden" name="tel" value="0770221268" />
                            	<input type="hidden" name="eml" value="kiarie@ipayafrica.com" />
                            	<input type="hidden" name="vid" value="demo" />
                            	<input type="hidden" name="cur" value="KES" />
                            	<input type="hidden" name="p1" value="" />
                            	<input type="hidden" name="p2" value="" />
                            	<input type="hidden" name="p3" value=""/>
                            	<input type="hidden" name="p4" value="" />
                            	<input type="hidden" name="cbk" value="http://cheapdomain.co.ke/modules/gateways/callback/ipay.php" />
                            	<input type="hidden" name="cst" value="kiarie@ipayafrica.com" />
                            	<input type="hidden" name="crl" value="0" />
                            	<input type="hidden" name="hsh" value="<?php echo hash_hmac('sha1', $datastring, 'demo');?>" /><input type="submit" value="Pay Now" /></form>
                                   <?php echo hash_hmac('sha1', $datastring, 'demo');
                                   echo '<br>'.$datastring;
                                   ?>
