<?php

declare(strict_types=1);

class SwitchConnector extends IPSModule {
    
    public function Create() {
        parent::Create();
        
        //Properties
        $connectorCount = 4;
        $this->RegisterPropertyInteger('ConnectorCount', $connectorCount);
        
        for ($i = 1; $i <= $connectorCount; $i++) {
            $this->RegisterPropertyInteger('InputVariable_'.$i, 0);
            $this->RegisterPropertyInteger('InputValue_'.$i, 0);
            $this->RegisterPropertyInteger('OutputVariable_'.$i, 0);
            $this->RegisterPropertyInteger('OutputValue_'.$i, 0);
        }
        
    }
    
    public function ApplyChanges() {
        parent::ApplyChanges();
        
        //Unregister all messages
        $messageList = array_keys($this->GetMessageList());
        foreach ($messageList as $message) {
            $this->UnregisterMessage($message, VM_UPDATE);
        }
        
        //Delete all references in order to readd them
        foreach ($this->GetReferenceList() as $referenceID) {
            $this->UnregisterReference($referenceID);
        }
        
        $connectorCount = $this->ReadPropertyInteger('ConnectorCount');
        for ($i = 1; $i <= $connectorCount; $i++) {
            if ($this->ReadPropertyInteger("InputVariable_".$i) > 0) {
                $this->RegisterMessage($this->ReadPropertyInteger("InputVariable_".$i), VM_UPDATE);
                $this->RegisterReference($this->ReadPropertyInteger("InputVariable_".$i));
            }
            if ($this->ReadPropertyInteger("OutputVariable_".$i) > 0) {
                $this->RegisterReference($this->ReadPropertyInteger("OutputVariable_".$i));
            }
        }
    }
    
    public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
        //https://www.symcon.de/en/service/documentation/developer-area/sdk-tools/sdk-php/messages/
        if ($Message == VM_UPDATE) {          
            $this->switchVariable($Data[0], $SenderID);
        }
    }
    
    public function GetConfigurationForm()
    {
        $form = json_decode(file_get_contents(__DIR__ . '/form.json'), true);
        
        $connectorCount = $this->ReadPropertyInteger('ConnectorCount');
        
        $base = $form['elements'][0];
        for ($i = 1; $i <= $connectorCount; $i++) {
            $formId = $i-1;
            $form['elements'][$formId] = $base;
            $form['elements'][$formId]['items'][0]['name'] = "InputVariable_".$i;
            $form['elements'][$formId]['items'][1]['name'] = "InputValue_".$i;
            $form['elements'][$formId]['items'][2]['name'] = "OutputVariable_".$i;
            $form['elements'][$formId]['items'][3]['name'] = "OutputValue_".$i;
        }
        //$this->SendDebug('elements', json_encode($form), 0);
        return json_encode($form);
    }
    
    private function switchVariable($Data, $SenderID) {        
        // $Data[0] Neuer Wert
        // $Data[1] true/false ob Änderung oder Aktualisierung.
        // $Data[2] Alter Wert 
        
        $connectorCount = $this->ReadPropertyInteger('ConnectorCount');
        for ($i = 1; $i <= $connectorCount; $i++) {
            if ($this->ReadPropertyInteger("InputVariable_".$i) == $SenderID) {
                $inputId = $i;
                //$this->LogMessage("$i ist mein gedrückter Button", KL_WARNING);
                break;
            }
        }
        
        if ($this->ReadPropertyInteger("OutputVariable_".$inputId) > 0) {
            switch ($this->ReadPropertyInteger('InputValue_'.$inputId)) {
                case 0: // true
                    if ($Data === true) { 
                        $this->SetResult($this->ReadPropertyInteger("OutputVariable_".$inputId), $this->ReadPropertyInteger("OutputValue_".$inputId));
                    }
                    break;
                case 1: // false
                    if ($Data === false) { 
                        $this->SetResult($this->ReadPropertyInteger("OutputVariable_".$inputId), $this->ReadPropertyInteger("OutputValue_".$inputId));
                    }
                    break;
                case 2: // true and false
                    if (($Data === false) || ($Data === true)) { 
                        $this->SetResult($this->ReadPropertyInteger("OutputVariable_".$inputId), $this->ReadPropertyInteger("OutputValue_".$inputId));
                    }
                    break;
            }
            
        }
    }
    

    private function SetResult($id, $outputValue) {
        switch ($outputValue) {
            case 0: // true
                $value = true;
                break;
            case 1: // false
                $value = false;
                break;
            case 2: // callScene
                $value = 2;
                break;
        }
        
        RequestAction($id, $value);
    }
}
?>