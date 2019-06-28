<?php
$msg = [
    "name" => "",
    "category" => "",
    "price" => "",
    "description" => "",
    "vegetarian" => "",
    "nut_traces" => "",
];

if(isset($_POST['submit']))
{
    $POST = filter_var_array($_POST,FILTER_SANITIZE_STRING);
    
    $name = trim($POST['name']);
    $category = trim($POST['category']);
    $price = number_format(trim($POST['price']),2); 
    $description = trim($POST['description']);
    $vegetarian = trim($POST['vegetarian']);
    $nut_traces = trim($POST['nut_traces']);
    

    // validate input
    if(empty($name) || $name === "")
    {
        $msg['name'] = "Name can not be empty";
    }
    
    if(empty($category) || $category === "** Please choose a category **")
    {
        $msg['category'] = "Category can not be empty";
    }

  
    // check pennys only has 2 decimals
    if( (strlen(strchr($price,'.')) -1 ) !== 2){
        $msg['price'] = "Please enter the price correctly (pounds.pennys | 0.00 ) ";
    }

    if(empty($price) || $price === "" || $price === "0.00" || $price == "0")
    {
        $msg['price'] = "Price can not be empty";
    }

    if(empty($description) || $description === "")
    {
        $msg['description'] = "Description can not be empty";
    }

    if($vegetarian !== "0" && $vegetarian !== "1")
    {
        $msg['vegetarian'] = "Choose if meal is vegetarian or Not";
    }


    if($nut_traces !== "0" && $nut_traces !== "1")
    {
        $msg['nut_traces'] = "Choose if meal has nut traces or Not";
    }

    else{
        
        $data = [
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'description' => $description,
            'vegetarian' => $vegetarian,
            'nut_traces' => $nut_traces,
         ];

                if(isset($_GET['add_item']))
                {

                    // if item is added successfuuly them lets redirect the user to the page where they can view the item 
                    if($this->add_new_item($data))
                    {
                        header("location: menu.php?category=$category");
                    }

                }
                elseif(isset($_GET['edit_item']))
                {
                    // lets do the same on the edit item page also if the update item was successfull
                    if($this->update_item($data))
                    {
                        header("location: menu.php?category=$category");
                    }
                

                }

     }
 
}
