             $tindakans = $data->tindakan;
            if ($tindakans != NULL) {
                $data->alltindakan=encode($data->tindakan));
                $num['tindakan']=sizeof($data->alltindakan);
             }           
             else {
                $num['tindakan']=0;
             }