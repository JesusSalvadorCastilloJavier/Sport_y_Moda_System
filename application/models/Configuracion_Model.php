<?php
    class Configuracion_Model extends CI_Model{

        public function updatePasswordByUsuarioId($datos){
            //print_r($datos);
            $update="call sp_updatePasswordByUsuarioId(".$datos['usuarioId'].",'".$datos['password']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($update);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function getAllUsuarios(){
            $respuesta=$this->db->query("call sp_getAllUsuarios;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getUsuarioByUsuarioId($usuarioId){
            $respuesta=$this->db->query("call sp_getUsuarioByUsuarioId(".$usuarioId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function addUsuario($datos){
            $insert="call sp_AddUsuario(".$datos['UsuarioId'].",'".$datos['Persona_Nombre']."'
                                        ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                        ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                        ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                        ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                        ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                        ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId']."
                                        ,".$datos['RoleId'].",'".$datos['Usuario_Usuario']."','".$datos['Usuario_Contrasenia']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function updateUsuario($datos){
            $update="call sp_UpdateUsuario(".$datos['UsuarioId'].",".$datos['usuarioModificarId'].",'".$datos['Persona_Nombre']."'
                                        ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                        ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                        ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                        ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                        ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                        ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId']."
                                        ,".$datos['RoleId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($update);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function deleteUsuario($datos){
            $delete="call sp_DeleteUsuarioByUsuarioId(".$datos['UsuarioModificadorId'].",".$datos['UsuarioId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($delete);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }



//----------------------------------------------------------------------------------- APARTADO DE COLORES



        public function getAllColores(){
            $respuesta=$this->db->query("call sp_getAll_CatColor;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function addColor($datos){
            $insert="call sp_AddColor(".$datos['UsuarioId'].",'".$datos['Color_Color']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function deleteColor($datos){
            $delete="call sp_DeleteColorByColorId(".$datos['UsuarioId'].",".$datos['ColorId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($delete);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function getColorByColorId($colorId){
            $respuesta=$this->db->query("call sp_getColorByColorId(".$colorId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function updateColor($datos){
            $update="call sp_UpdateColor(".$datos['UsuarioId'].",".$datos['ColorId'].",'".$datos['Color_Color']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($update);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }
    

//----------------------------------------------------------------------------------- APARTADO DE ROLES

    public function addRole($datos){
        $insert="call sp_AddRole(".$datos['UsuarioId'].",'".$datos['Role_Role']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function deleteRole($datos){
        $delete="call sp_DeleteRoleByRoleId(".$datos['UsuarioId'].",".$datos['RoleId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function getRoleByRoleId($RoleId){
        $respuesta=$this->db->query("call sp_getRoleByRoleId(".$RoleId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function updateRole($datos){
        $update="call sp_UpdateRole(".$datos['UsuarioId'].",".$datos['RoleId'].",'".$datos['Role_Role']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($update);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function getMenuHijo($RoleId){
        $respuesta=$this->db->query("call sp_getMenuHijoByRolRolId(".$RoleId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function getMenuHijoByRolId($RoleId){
        $respuesta=$this->db->query("call sp_getAllMenuHijoByRolId(".$RoleId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function getAllMenuHijo(){
        $respuesta=$this->db->query("call sp_getAllMenuHijo;");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function deleteAcceso($datos){
        $delete="call sp_DeleteAccesoByRoleId(".$datos['UsuarioId'].",".$datos['AccesoId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function addAcceso($datos){

        $delete="call sp_DeleteAccesoByRoleId(".$datos['UsuarioId'].",".$datos['RoleId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }

        for($i=0;$i<count($datos['MenuHijoIds']);$i++){
            $insert="call sp_AddAcceso(".$datos['UsuarioId'].",".$datos['MenuHijoIds'][$i].",".$datos['RoleId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);    
        }
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    //----------------------------------------------------------------------------------- APARTADO DE TALLAS

    public function addTalla($datos){
        $insert="call sp_AddTalla(".$datos['UsuarioId'].",'".$datos['Talla_Talla']."','".$datos['Talla_Numero']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function deleteTalla($datos){
        $delete="call sp_DeleteTallaByTallaId(".$datos['UsuarioId'].",".$datos['TallaId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function getTallaByTallaId($TallaId){
        $respuesta=$this->db->query("call sp_getTallaByTallaId(".$TallaId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function updateTalla($datos){
        $update="call sp_UpdateTalla(".$datos['UsuarioId'].",".$datos['TallaId'].",'".$datos['Talla_Talla']."','".$datos['Talla_Numero']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($update);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    //----------------------------------------------------------------------------------- APARTADO DE MARCAS



    public function getAllMarcas(){
        $respuesta=$this->db->query("call sp_getAll_CatMarca;");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function addMarca($datos){
        $insert="call sp_AddMarca(".$datos['UsuarioId'].",'".$datos['Marca_Marca']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function deleteMarca($datos){
        $delete="call sp_DeleteMarcaByMarcaId(".$datos['UsuarioId'].",".$datos['MarcaId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function getMarcaByMarcaId($marcaId){
        $respuesta=$this->db->query("call sp_getMarcaByMarcaId(".$marcaId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function updateMarca($datos){
        $update="call sp_UpdateMarca(".$datos['UsuarioId'].",".$datos['MarcaId'].",'".$datos['Marca_Marca']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($update);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    //----------------------------------------------------------------------------------- APARTADO DE PROVEEDORES


    public function getAllProveedores(){
        $respuesta=$this->db->query("call sp_getAllProveedores;");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function getProveedorByProveedorId($proveedorId){
        $respuesta=$this->db->query("call sp_getProveedorByProveedorId(".$proveedorId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function addProveedor($datos){
        $insert="call sp_AddProveedor(".$datos['UsuarioId'].",'".$datos['Persona_Nombre']."'
                                    ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                    ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                    ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                    ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                    ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                    ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function updateProveedor($datos){
        $update="call sp_UpdateProveedor(".$datos['UsuarioId'].",".$datos['proveedorModificarId'].",'".$datos['Persona_Nombre']."'
                                    ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                    ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                    ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                    ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                    ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                    ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($update);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function deleteProveedor($datos){
        $delete="call sp_DeleteProveedorByProveedorId(".$datos['UsuarioModificadorId'].",".$datos['ProveedorId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    //----------------------------------------------------------------------------------- APARTADO DE CLIENTES


    public function getAllClientes(){
        $respuesta=$this->db->query("call sp_getAllClientes;");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function getClienteByClienteId($clienteId){
        $respuesta=$this->db->query("call sp_getClienteByClienteId(".$clienteId.");");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function addCliente($datos){
        $insert="call sp_AddCliente(".$datos['UsuarioId'].",'".$datos['Persona_Nombre']."'
                                    ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                    ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                    ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                    ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                    ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                    ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function updateCliente($datos){
        $update="call sp_UpdateCliente(".$datos['UsuarioId'].",".$datos['clienteModificarId'].",'".$datos['Persona_Nombre']."'
                                    ,'".$datos['Persona_ApellidoPaterno']."','".$datos['Persona_ApellidoMaterno']."'
                                    ,'".$datos['Persona_FechaNacimiento']."',".$datos['Persona_SexoId']."
                                    ,'".$datos['Contacto_TelRecados']."','".$datos['Contacto_TelCasa']."'
                                    ,'".$datos['Contacto_TelCelular']."','".$datos['Contacto_Email']."'
                                    ,'".$datos['Direccion_Calle']."',".$datos['Direccion_NumeroInterior']."
                                    ,".$datos['Direccion_NumeroExterior'].",".$datos['EstadoId'].",".$datos['MunicipioId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($update);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    public function deleteCliente($datos){
        $delete="call sp_DeleteClienteByClienteId(".$datos['UsuarioModificadorId'].",".$datos['ClienteId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($delete);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }

    
    //----------------------------------------------------------------------------------- APARTADO DE CAJA

    public function getAllmontosCaja(){
        $respuesta=$this->db->query("call sp_getAllCaja;");
        $data=$respuesta->result_array();
        $respuesta->free_result();
        $respuesta->next_result();
        return $data;
    }

    public function addMontoCaja($datos){
        $insert="call sp_AddMontoCaja(".$datos['UsuarioId'].",".$datos['monto'].",'".$datos['fecha']."','".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
        $query=$this->db->query($insert);
        if(!$query){
            return var_dump($this->db->error());
        }
        return true;
    }
}
?>