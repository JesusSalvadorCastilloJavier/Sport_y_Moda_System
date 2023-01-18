<?php
    class Almacen_Model extends CI_Model{
        
        public function getAllPrendas(){
            $respuesta=$this->db->query("call sp_getAllPrendas;");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function addPrenda($datos){
            $insert="call sp_AddPrenda(".$datos['UsuarioId'].",'".$datos['Prenda_Prenda']."'
                                        ,'".$datos['Prenda_Descripcion']."',".$datos['Prenda_Inventario']."
                                        ,".$datos['Prenda_PrecioEntrada'].",".$datos['Prenda_PrecioSalida']."
                                        ,".$datos['Prenda_GeneroId'].",".$datos['Prenda_MarcaId']."
                                        ,".$datos['Prenda_TallaId'].",".$datos['Prenda_ColorPrimarioId']."
                                        ,".$datos['Prenda_ColorSecundarioId'].",".$datos['Prenda_ProveedorId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function getAllPrendaByPrendaId($PrendaId){
            $respuesta=$this->db->query("call sp_getPrendaByPrendaId(".$PrendaId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function getAllPrendaByPrendaId_Tiket($PrendaId){
            $respuesta=$this->db->query("call sp_getPrendaByPrendaId_Tiket(".$PrendaId.");");
            $data=$respuesta->result_array();
            $respuesta->free_result();
            $respuesta->next_result();
            return $data;
        }

        public function updatePrenda($datos){
            $insert="call sp_UpdatePrenda(".$datos['UsuarioId'].",".$datos['PrendaId'].",'".$datos['Prenda_Prenda']."'
                                        ,'".$datos['Prenda_Descripcion']."',".$datos['Prenda_Inventario']."
                                        ,".$datos['Prenda_PrecioEntrada'].",".$datos['Prenda_PrecioSalida']."
                                        ,".$datos['Prenda_GeneroId'].",".$datos['Prenda_MarcaId']."
                                        ,".$datos['Prenda_TallaId'].",".$datos['Prenda_ColorPrimarioId']."
                                        ,".$datos['Prenda_ColorSecundarioId'].",".$datos['Prenda_ProveedorId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function deletePrenda($datos){
            $delete="call sp_DeletePrendaByPrendaId(".$datos['UsuarioIdGlobal'].",".$datos['PrendaId'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($delete);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

        public function entradaPrenda($datos){
            $insert="call sp_AddCantPrenda(".$datos['UsuarioId'].",".$datos['PrendaId'].",'".$datos['Prenda_Prenda']."'
                                        ,'".$datos['Prenda_Descripcion']."',".$datos['Prenda_Inventario']."
                                        ,".$datos['Prenda_PrecioEntrada'].",".$datos['Prenda_PrecioSalida']."
                                        ,".$datos['Prenda_GeneroId'].",".$datos['Prenda_MarcaId']."
                                        ,".$datos['Prenda_TallaId'].",".$datos['Prenda_ColorPrimarioId']."
                                        ,".$datos['Prenda_ColorSecundarioId'].",".$datos['Prenda_ProveedorId']."
                                        ,".$datos['EntradaPrenda_Cantidad'].",'".gethostname()."','".$_SERVER['REMOTE_ADDR']."');";
            $query=$this->db->query($insert);
            if(!$query){
                return var_dump($this->db->error());
            }
            return true;
        }

    }
?>