<?php
require "../../utils/functions.php";
require "../../db/connection.php";


$pdo = pdo_connect_mysql();
?>
<script type="text/javascript" src="script.js"></script>


<?=template_header('Read')?>

    <div class="content read">
        <h2>Salary Calculator</h2>

        <div class="salary_css">
            <label for="base_salary">Base Salary</label>
            <input type="number" id="base_salary" placeholder="Enter Base Salary" required/>
        </div>

        <div class="salary_css">
            <label for="meal_allowance">Meal Allowance</label>
            <select name="meal_allowance" id="meal_allowance" required>
                <option value="no_allowance">No meal allowance</option>
                <option value="card">Meal Card</option>
                <option value="money">Money</option>
            </select>
        </div>

        <div class="salary_css">
            <label for="meal_allowance_amount">Meal Allowance Amount</label>
            <input
                    required
                    type="number"
                    id="meal_allowance_amount"
                    placeholder="Enter Meal Allowance Amount"
                    value="0"
                    disabled
            />
        </div>
        <div class="salary_css">
            <label for="meal_days">How many days did you work?</label>
            <input
                    required
                    type="number"
                    id="meal_days"
                    placeholder="Enter Meal Days"
                    value="0"
                    disabled
            />
        </div>

        <button class="btn btn-dark mb-3 salary_css" id="calculate">Calculate</button>

        <table class="table table-hover text-center mt-4">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Gross Salary</th>
                <th scope="col">Taxes</th>
                <th scope="col">Meal Allowance</th>
                <th scope="col">Meal Allowance Taxed</th>
                <th scope="col">IRS Tax</th>
                <th scope="col">SS Tax:</th>
                <th scope="col"> Net Salary</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <th><span id="gross_salary">0</span></th>
                    <td><span id="taxes">0</span></td>
                    <td><span id="meal_allowance_value">0</span></td>
                    <td><span id="meal_allowance_taxed">0</span></td>
                    <td><span id="descontos_irs">0</span></td>
                    <td><span id="descontos_ss">0</td>
                    <th><span id="net_salary">0</span></th>
                </tr>
            </tbody>
        </table>

<?=template_footer()?>
