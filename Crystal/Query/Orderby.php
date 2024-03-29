<?php
/**
 * Crystal DBAL
 *
 * An open source application for database manipulation
 *
 * @package		Crystal DBAL
 * @author		Martin Rusev
 * @link		http://crystal-project.net
 * @since		Version 0.1
 * @version     0.5
 */

// ------------------------------------------------------------------------
class Crystal_Query_Orderby 
{

    function __construct($method=null, $order=null)
    {
  

		if(is_array($order) && !empty($order))
		{
			
			
			$this->query->sql = " ORDER BY ";
			$this->query->type = 'order_by';
				

			$filtered_params = Crystal_Parser_String::parse($order[0]);
			
			/** WORKS FOR SINGLE ELEMENTS order_by('product_id') **/
			if(is_string($filtered_params['string']))
			{
				
				$filtered_order = self::_check_order($filtered_params['string']);
				
				$this->query->sql .= " ? ? ";
				$this->query->params = array($filtered_order['column'], $filtered_order['order']);
									
			}
			/** WORKS FOR MULTIPLE ELEMENTS order_by('product_id, -category_id') **/
			else
			{
				
				
				end($filtered_params);
	        	$last_element = key($filtered_params);
	        	reset($filtered_params);
				
				foreach($filtered_params as $key => $value)
				{
					$filtered_order = self::_check_order($value);
					
					$this->query->sql .= " ? ? ";
					$this->query->params[] = array($filtered_order['column'], $filtered_order['order']);
	
					
					if($key != $last_element){  $this->query->sql .=','; }
					
				}
				
				
			}
						
						
						
			}
	        else
	        {
	
	           $this->order = '';
	
	        }
    	
		return $this->query->sql;
      
    }
    
    private function _check_order($string)
    {
    	$asc = strpos($string, '-');
    	
    	$order = array();
    	
		if($asc == True or $asc === 0)
    	{
    		
    		$order['column'] = preg_replace('/-/', '', $string, 1);
    		$order['order'] = 'ASC';	
    		
    	}
    	else
    	{
    		
    		$order['column'] = $string;
    		$order['order'] = 'DESC';
    		
    	}
    	
    	return $order;
    	
    }


    public function __toString() 
	{
        return $this->order;
    }
    
    
}