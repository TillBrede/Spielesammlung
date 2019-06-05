<?
class Zahlenraten extends IPSModule {
    
    public function Create(){
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
        $this->RegisterVariableInteger("DieZahl", "DieZahl", "DieZahl", 0);
		$this->RegisterVariableInteger("ZuegeUebrig", "ZügeÜbrig", "Zuege", 1);
		$this->RegisterVariableInteger("DeineZahl", "Deines Zahl ist", "GkG", 2);
		$this->RegisterVariableInteger("DeinTipp", "DeinTipp", "DeinTipp", 3);
		$this->RegisterScript("Generieren", "Generieren", "<?php ZR_Generieren(" . $this->InstanceID . ");", 4);
        $this->EnableAction("DeinTipp");
		
		
    }

    public function Destroy(){
        //Never delete this line!
        parent::Destroy();
        
    }

    public function ApplyChanges(){
        //Never delete this line!
        parent::ApplyChanges();
    }
	
	

	public function Generieren() {
		
		$Parent = $this->InstanceID;
		$DieZahl = mt_rand(0, 10); 
		IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), false);

		SetValue(IPS_GetObjectIDByIdent("DieZahl", $Parent), $DieZahl);
		SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 3);
		SetValue(IPS_GetObjectIDByIdent("DeinTipp", $Parent), 0);
		SetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent), 5);
	
	}
	
	public function RequestAction($Ident, $Value) {
		
		$Parent = $this->InstanceID;
		
		switch ($Ident) {
			case "DeinTipp":
				SetValue(IPS_GetObjectIDByIdent($Ident, $Parent), $Value);
				$Tipp = GetValue(IPS_GetObjectIDByIdent("DeinTipp", $Parent));
				$DieZahl = GetValue(IPS_GetObjectIDByIdent("DieZahl", $Parent));

				$Verbleibend = GetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent));

				if ($Verbleibend >= 1) {
					if ($Tipp > $DieZahl) {
						SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 0);
						$Verbleibend--;
					} elseif($Tipp < $DieZahl) {
						SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 1);
						$Verbleibend--;
					} elseif($Tipp = $DieZahl) {
						SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 2);
						echo "Gewonnen!";
						IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), true);
					}
				}

				if($Verbleibend == 0) {
					echo "Verloren!" . "\n\nDie Zahl war: " . $DieZahl ;
					SetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent), 0);
					IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), true);
				}

		
					SetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent), $Verbleibend);
		}
	}  	

}
?>