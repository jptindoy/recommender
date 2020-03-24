@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Documentation</h1>
            </div><!-- /.col -->
            
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">    
        <h4 class="mb-2">Project Objectives</h4>
        <label for="">1. Purpose of the Project</label>
        <p>
            The researchers are hoping to enhance the marketing and sales capability using a PRS to help the department in their interaction with the customers. Based on an interview conducted with Mr. Eleazer Macaraig (December 9, 2019), Store Accountant, below are the list of problems that the store is facing in its operation:
            <ol>
                <li>
                    The store has acquired a new Point of Sale (POS) system but it does not have a built-in recommender system that would recommend products to the management that can be used in the marketing and planning.
                </li>
                <li>
                    List of potential products that are saleable in seasons, occasion or events are not determined. There are products that are worth to be displayed in peak season. For example, from the month of November to February – what products are most saleable, in university’s events like enrolment or graduation day. This will increase the store’s profitability if trends in those seasons or occasions are identified.
                </li>
                <li>
                    The products that are frequently bought together in a single transaction are not given importance. For an example, when a walk-in customer enters the store facility buying wheat bread then buying jam is likely to occur or a customer buying wheat bread and jam tends also to buy plastic spoon. This transaction can happen at several times can increase profitability if association between products is promoted in the management.
                </li>
                <li>
                    There is not enough basis of the product quantity to be ordered from the suppliers. The store is often face with product supply shortage. For an instance, a customer goes inside the store building and look for a sachet of shoe polisher, having not seen any, went to a store worker and ask for where the shoe polisher is located. The store worker then leads the customer to the specific shelf but with a surprise that they run out of supply. This is a result of poor management and without good basis of how much quantity need to be reorder so that instances would not happen again. 
                </li>
            </ol>
        </p>
        <label for="">2. General Objective</label>
        <p>
            The main objective of the project is to develop a product recommender system for University Store of Adventist University of the Philippines in Silang, Cavite.
        </p>
        <label for="">3. Specific Objective</label>
        <p>
            In order to solve the current problem that the store is facing, the researchers develop a system that will be used to help the store so that they can be efficient and accurate in preparation of the products. Below is the list of solutions that we want to implement to solve the current issues:
            <ol>
                <li>
                    To develop a system that will recommend products.
                </li>
                <li>
                    To develop a system that determine saleable products in different seasons or in events.
                </li>
                <li>
                    To develop a system that will discover customers buying patterns.
                </li>
                <li>
                    To develop a system that will predict enough product quantity need to be reordered.
                </li>
            </ol>
        </p>
        <label for="">4. Scope and Limitations of the Project</label>
        <p>
            This project is focused on developing a PRS that will recommend products to the store management. The PRS requires raw data that will be manually feed to the proposed system. The steps of collecting and processing the data are the following:
            <ol>
                <li>
                    Identify the raw data that will be imported.
                </li>
                <li>
                    Import the selected data.
                </li>
                <li>
                    Choose the relevant data columns that need to be examined.
                </li>
                <li>
                    Extract the relevant data from the raw data.
                </li>
                <li>
                    Perform the task using a technique and algorithm.  
                </li>
                <li>
                    Interpret and present the results.
                </li>
            </ol>

            The data that was used during the study were obtained from December 2019 to March 2020. The raw data will go through the process of data mining to recommend products and discover patterns and trends. The system can generate recommendations of products based on by occasion, monthly and yearly basis. Options will be provided so that the management can choose depending on their preferences. The system will also display statistical data like graphs by using the results from filtering process that can be used for in marketing and sales planning.
            <br>
            The PRS is a web-based system that supports any web browsers latest version. The proposed system will use HTML, CSS. Bootstrap 4 and Admin LTE 3 for the user interface layout, design and responsiveness. Laravel 6 which a sever side framework for PHP language. Javascript to interact with the users. MySQL for creating and managing the PRS database. The developers will also use Git, a version-control system that allows to monitor revision in source code like edition, deletion and the responsible editor during coding time and a Github account for repository where all the source code will be uploaded for accessibility of the source code and collaboration with the developers.
            <br>
            The system is for internal use with an in-house unit server. It cannot be accessed from different computer or laptop devices anywhere outside the location where unit server is located. Viewing of mobile devices will not be supported due to screen size factor.

        </p>
        <label for="">5. Significance of the Project</label>
        <p>
            The proposed system is important to help the store, AUP, students and future researchers.
            <br>
            <strong>For the University Store.</strong>
            The system will be a big help for the store management in decision making. The recommendation will aid the store marketing and sales Planning. This can be used to monitor what the customers like to by the most and what to buy the least. With this useful info, the store management will know what to sell and what not to sell. Also, the store management will be able to know the preferences of their customers so that they can render a good service.
            <br>
            <strong>For the AUP.</strong>
            This will also benefit Adventist University of the Philippines, if it will be used as a pattern of building PRS on other department inside the campus that is related to retailing and selling of products. For example, the Health Foods Canteen, extension of Food Factory department.
            <br>
            <strong>For the students and future researchers.</strong>
            This system can also be used as a reference document to future researchers and students who plans to develop a recommender system in retailing environment.

        </p>
        {{-- <label for="">2. Purpose of the Project</label>
        <p>
           
        </p> --}}
        <br>
    </div> 
</div>
<!-- /.content --> 
@endsection
