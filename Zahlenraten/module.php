<?
class Zahlenraten extends IPSModule {
    
    public function Create(){
        //Never delete this line!
        parent::Create();
        
        //These lines are parsed on Symcon Startup or Instance creation
        //You cannot use variables here. Just static values.
		
		$this->RegisterPropertyInteger("Max", 15);
		$this->RegisterPropertyInteger("Min", 0);
		
		if(!IPS_VariableProfileExists("Zuege")) {
			IPS_CreateVariableProfile("Zuege", 1);
			IPS_SetVariableProfileValues("Zuege", 0, 5, 1);
		}
		if(!IPS_VariableProfileExists("GkG")) {
			IPS_CreateVariableProfile("GkG", 1);
			IPS_SetVariableProfileAssociation("GkG", 0, "kleiner", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 1, "größer", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 2, "gleich", "Transparent", -1 );
			IPS_SetVariableProfileAssociation("GkG", 3, "", "Transparent", -1 );
			IPS_SetVariableProfileValues("GkG", 0, 2, 1);
		}
		if(!IPS_VariableProfileExists("DeinTipp")) {
			IPS_CreateVariableProfile("DeinTipp", 1);
			IPS_SetVariableProfileValues("DeinTipp", 0, $this->ReadPropertyInteger("Max"), 1);
		}
		
        $this->RegisterAttributeInteger("GeheimeZahl", 0);
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
		
		if ($this->ReadPropertyInteger("Min") > $this->ReadPropertyInteger("Max")) {
			$this->SetStatus(200);
			
		} else {
			$this->SetStatus(102);
		}
    }
	
	

	public function Generieren() {
		
		$Parent = $this->InstanceID;
		if ($this->GetStatus() == 200 ) {
					echo $this->Translate("The modulse stopped working");
		} else {
		$DieZahl = mt_rand($this->ReadPropertyInteger("Min"), $this->ReadPropertyInteger("Max")); 
		IPS_SetDisabled(IPS_GetObjectIDByIdent("DeinTipp", $Parent), false);

		$this->WriteAttributeInteger("GeheimeZahl", $DieZahl);
		SetValue(IPS_GetObjectIDByIdent("DeineZahl", $Parent), 3);
		SetValue(IPS_GetObjectIDByIdent("DeinTipp", $Parent), 0);
		SetValue(IPS_GetObjectIDByIdent("ZuegeUebrig", $Parent), 5);
		}
	
	}
	
	public function RequestAction($Ident, $Value) {
		
		$Parent = $this->InstanceID;
		
		switch ($Ident) {
			case "DeinTipp":
				if ($this->GetStatus() == 200 ) {
					echo $this->Translate("The modulse stopped working");
				} else {		
			
					if ($Value > $this->ReadPropertyInteger("Max") || $Value < $this->ReadPropertyInteger("Min")) {
						$Min = $this->ReadPropertyInteger("Min");
						$Max = $this->ReadPropertyInteger("Max");
						$MiniMax = $this->Translate("The number has to be between %d and %d!");
						echo sprintf($MiniMax, $Min, $Max);
					} else {
						SetValue($this->GetIDForIdent($Ident), $Value);
						$Tipp = GetValue($this->GetIDForIdent("DeinTipp"));
						$DieZahl = $this->ReadAttributeInteger("GeheimeZahl");
						$Verbleibend = GetValue($this->GetIDForIdent("ZuegeUebrig"));

				$Verbleibend = GetValue($this->GetIDForIdent("ZuegeUebrig"));

				if ($Verbleibend >= 1) {
					if ($Tipp > $DieZahl) {
						SetValue($this->GetIDForIdent("DeineZahl"), 0);
						$Verbleibend--;
					} elseif($Tipp < $DieZahl) {
						SetValue($this->GetIDForIdent("DeineZahl"), 1);
						$Verbleibend--;
					} elseif($Tipp = $DieZahl) {
						SetValue($this->GetIDForIdent("DeineZahl"), 2);
						echo "Gewonnen!";
						IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
					}
				}

				if($Verbleibend == 0) {
					echo "Verloren!" . "\n\nDie Zahl war: " . $DieZahl ;
					SetValue($this->GetIDForIdent("ZuegeUebrig"), 0);
					IPS_SetDisabled($this->GetIDForIdent("DeinTipp"), true);
				}

		
					SetValue($this->GetIDForIdent("ZuegeUebrig"), $Verbleibend);
		}
	}  	

}
?>