<div class="container-fluid">
    <div class="row">
        <div class="col sm-12">
          <h1 class="text-center mb-2"> <i class="fas fa-money-bill-wave"></i> Transactions  </h1>
           
          <h5 class='text-center' > <u> Please choose a month to view orders from </u> </h5>
          <div class='row'>
              <div class='col-sm-6'>
                  <h5 class='text-center'>  <u> <?= $this->this_year ?> </u> </h5>    
                  <table class="table table-inverse">
                      <thead>
                          <th> <u> Month </u></th>
                          <th>  <u>Total Sales</u></th>
                      </thead>
                      <tbody>
                          <tr>
                              <?php $this->show_this_year_month_cycle(); ?>
                        </tr>
                      </tbody>
                  </table>
              </div>

               <div class='col-sm-6'>
                  <h5 class='text-center'> <u> <?= $this->last_year ?> </u>  </h5>    
                  <table class="table table-inverse">
                      <thead>
                          <th> <u> Month </u> </th>
                          <th> <u> Total Sales </u> </th>
                      </thead>  
                      <tbody>
                          <tr> 
                            <?php $this->show_last_year_month_cycle(); ?>
                          </tr>
                      </tbody>
                  </table> 
               </div>
          </div> 
        </div>
    </div>


