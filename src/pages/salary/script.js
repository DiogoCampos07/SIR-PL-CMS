window.addEventListener("load", () => {
    let taxes = {
    710: 0,
    1015: 11.3,
    1577: 17.2,
    2109: 21.9,
    5241: 32.3,
    11384: 39.2,
    25505: 43.8,
};

    //get data from UI
    let typeMealAllowance = document.getElementById("meal_allowance");
    let mealAllowance = document.getElementById("meal_allowance_amount");
    let mealDays = document.getElementById("meal_days");

    typeMealAllowance.addEventListener("change", () => {
    //If typeMealAllowance = no_allowance, mealAllowance, mealDays are disable
    if (typeMealAllowance.value === "no_allowance") {
    mealAllowance.value = 0;
    mealDays.value = 0;
    mealAllowance.disabled = true;
    mealDays.disabled = true;
} else {
    mealAllowance.disabled = false;
    mealDays.disabled = false;
}
});

    mealDays.addEventListener("change", () => {
    //if already exists error message delete it
    if (mealDays.parentNode.querySelector("span")) {
    mealDays.parentNode.querySelector("span").remove();
    mealDays.style.border = "1px solid #000000";
}
    //Check if meel days is a number between 31 and 1
    if (mealDays.value > 31 || mealDays.value < 1) {
    mealDays.style.border = "1px solid red";
    let span = document.createElement("span");
    span.innerHTML = "Please enter a valid number between 1 and 31";
    span.style.color = "red";
    span.style.fontWeight = "bold";
    mealDays.parentNode.appendChild(span);
}
});

    //Get Tax for the grossSalary
    function getTaxRate(grossSalary, taxTable) {
    for (let salary in taxTable) {
    if (salary >= grossSalary) {
    return taxTable[salary];
}
}
    return 43.8;
}

    function calculateMealAllowance(
    netSalary,
    grossSalary,
    typeMealAllowance,
    mealAllowance,
    mealDays
    ) {
    let mealAllowanceTaxed = 0;
    // If typeMealAllowance = no_allowance
    if (typeMealAllowance === "no_allowance") {
    return {netSalary: netSalary, grossSalary: grossSalary};
    // If typeMealAllowance = card
} else if (typeMealAllowance === "card") {
    if (mealAllowance >= 7.33) {
    mealAllowanceTaxed = mealAllowance - 7.33;
    grossSalary = grossSalary + (mealAllowance - 7.33) * mealDays;
    netSalary = netSalary + 7.33 * mealDays;
} else {
    netSalary = netSalary + mealAllowance * 22;
}
    // If typeMealAllowance = money
} else if (typeMealAllowance === "money") {
    if (mealAllowance >= 4.57) {
    mealAllowanceTaxed = mealAllowance - 4.57;
    grossSalary = grossSalary + (mealAllowance - 4.57) * mealDays;
    netSalary = netSalary + 4.57 * 22;
} else {
    netSalary = netSalary + mealAllowance * mealDays;
}
}
    return {netSalary: netSalary, grossSalary: grossSalary, mealAllowanceTaxed: mealAllowanceTaxed};
}

    // Calculate Net Salary
    function calculateNetSalary() {
    // Get values
    let netSalaryTemp = 0;
    let grossSalary = +document.getElementById("base_salary").value;
    let typeMealAllowance = document.getElementById("meal_allowance").value;
    let mealAllowance = +document.getElementById("meal_allowance_amount").value;
    const mealDays = +document.getElementById("meal_days").value;
    const result = calculateMealAllowance(
    netSalaryTemp,
    grossSalary,
    typeMealAllowance,
    mealAllowance,
    mealDays
    );
    netSalaryTemp = result.netSalary;
    grossSalary = result.grossSalary;
    const taxOwed = getTaxRate(grossSalary, taxes);
    // Get values for taxes
    const descontos_ss = grossSalary * (11 / 100);
    const descontos_irs = grossSalary * (taxOwed / 100);
    // Calculate  net salary
    const netSalary =
    grossSalary - descontos_irs - descontos_ss + netSalaryTemp;
    // Permit only 2 decimal cases
    document.getElementById("net_salary").textContent = netSalary.toFixed(2);
    document.getElementById("descontos_irs").textContent =
    descontos_irs.toFixed(2);
    document.getElementById("descontos_ss").textContent =
    descontos_ss.toFixed(2);
    document.getElementById("gross_salary").textContent =
    grossSalary.toFixed(2);
    document.getElementById("taxes").textContent = taxOwed.toFixed(2) + "%";
    document.getElementById("meal_allowance_value").textContent =
    (mealDays * mealAllowance).toFixed(2);
    document.getElementById("meal_allowance_taxed").textContent =
    (result.mealAllowanceTaxed * mealDays).toFixed(2);
}

    const calculateButton = document.getElementById("calculate");
    calculateButton.addEventListener("click", calculateNetSalary);
});
