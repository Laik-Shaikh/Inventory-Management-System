$(document).ready(function () {
  var DOMAIN =
    "http://localhost/PHP Programs (Laik)/PHP Projects/Inventory Management System/public_html";
  $("#register_form").on("submit", function () {
    var status = false;
    var name = $("#username");
    var email = $("#email");
    var password1 = $("#password1");
    var password2 = $("#password2");
    var role = $("#role");

    //Regrex
    var e_patt = new RegExp(
      /^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/
    );
    if (name.val() === "") {
      name.addClass("border-danger");
      $("#u_error").html(
        "<span class='text-danger'>User Name is Required</span>"
      );
      status = false;
    } else {
      name.removeClass("border-danger");
      $("#u_error").html("");
      status = true;
    }
    if (!e_patt.test(email.val())) {
      email.addClass("border-danger");
      $("#e_error").html(
        "<span class='text-danger'>Please Enter Valid Email Address</span>"
      );
      status = false;
    } else {
      email.removeClass("border-danger");
      $("#e_error").html("");
      status = true;
    }
    if (password1.val() == "" || password1.val().length > 8) {
      password1.addClass("border-danger");
      $("#p1_error").html(
        "<span class='text-danger'>Please Enter more than 8 digit password</span>"
      );
      status = false;
    } else {
      password1.removeClass("border-danger");
      $("#p1_error").html("");
      status = true;
    }
    if (password2.val() == "" || password2.val().length > 8) {
      password2.addClass("border-danger");
      $("#p2_error").html(
        "<span class='text-danger'>Please Enter more than 8 digit password</span>"
      );
      status = false;
    } else {
      password2.removeClass("border-danger");
      $("#p2_error").html("");
      status = true;
    }
    if (role.val() == "") {
      role.addClass("border-danger");
      $("#role_error").html(
        "<span class='text-danger'>Please Choose Required Fields</span>"
      );
      status = false;
    } else {
      role.removeClass("border-danger");
      $("#role_error").html("");
      status = true;
    }

    if (password1.val() === password2.val() && status === true) {
      $.ajax({
        url: decodeURI(DOMAIN + "/includes/process.php"),
        method: "POST",
        data: {
          username: name.val(),
          email: email.val(),
          password1: password1.val(),
          password2: password2.val(),
          role: role.val(),
        },
        success: function (data) {
          console.log(data);
          if (data === "EMAIL ADDRESS ALREADY EXISTS") {
            email.addClass("border-danger");
            $("#e_error").html(
              "<span class='text-danger'>Email Address Alredy Exists</span>"
            );
          } else if (data === "Something Went Wrong") {
            alert("Something Went Wrong");
          } else {
            window.location.href = encodeURI(
              DOMAIN + "/index.php?msg=You are registered Now you can login"
            );
          }
        },
      });
    } else {
      password2.addClass("border-danger");
      $("#p2_error").html(
        "<span class='text-danger'>Password is not Matched</span>"
      );
      status = true;
    }
  });

  // for login
  $("#login-form").on("submit", function () {
    var login_email = $("#login_email");
    var login_password = $("#login_password");
    var status = false;

    if (login_email.val() === "") {
      login_email.addClass("border-email");
      $("#email_error").html(
        "<span class='text-danger'>Please Email Address</span>"
      );
      status = false;
    } else {
      login_email.removeClass("border-email");
      $("#email_error").html("");
      status = true;
    }
    if (login_password.val() === "") {
      login_password.addClass("border-email");
      $("#pass_error").html(
        "<span class='text-danger'>Please Enter Password</span>"
      );
      status = false;
    } else {
      login_email.removeClass("border-email");
      $("#pass_error").html("");
      status = true;
    }

    if (status) {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          login_email: login_email.val(),
          login_password: login_password.val(),
        },
        success: function (data) {
          console.log(data);
          if (data === "0Email Address is Not Registered") {
            login_email.addClass("border-danger");
            $("#email_error").html(
              "<span class='text-danger'>It Seems Like You Are Not Registered</span>"
            );
          } else if (data === "1INVALID PASSWORD") {
            login_password.addClass("border-danger");
            $("#pass_error").html(
              "<span class='text-danger'>Invalid Password</span>"
            );
          } else {
            return (window.location.href = encodeURI(
              DOMAIN + "/dashboard.php"
            ));
          }
        },
      });
    }
  });

  function fetch_category() {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: { getCategory: 1 },
      success: function (data) {
        var root = "<option value='0'>Root</option>";
        var choose = "<option value=''>Choose Category</option>";
        $("#parent_cat").html(root + data);
        $("#select_cat").html(choose + data);
      },
    });
  }
  fetch_category();

  // for adding category
  $("#category_form").on("submit", function () {
    var category_name = $("#category_name");
    var parent_cat = $("#parent_cat");
    var status = false;
    if (category_name.val() === "") {
      category_name.addClass("border-danger");
      $("#cat_error").html(
        "<span class='text-danger'>Please Enter a Category Name</span>"
      );
      status = false;
    } else {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          parent_cat: parent_cat.val(),
          category_name: category_name.val(),
        },
        success: function (data) {
          if (data === "CATEGORY ADDED") {
            category_name.removeClass("border-danger");
            alert("CATEGORY ADDED");
            $("#cat_error").html(
              "<span class='text-success'>New Category Added Successfully..!</span>"
            );
            $("#category_name").val("");
            fetch_category();
          } else {
            alert(data);
          }
        },
      });
    }
    fetch_category();
  });

  // for adding brand
  $("#brand-form").on("submit", function () {
    var brand_name = $("#brand_name");
    if (brand_name.val() === "") {
      brand_name.addClass("border-danger");
      $("#brand_error").html(
        "<span class='text-danger'>Please Enter a Brand Name</span>"
      );
    } else {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          brand_name: brand_name.val(),
        },
        success: function (data) {
          if (data === "Brand Added") {
            brand_name.removeClass("border-danger");
            $("#brand_error").html(
              "<span class='text-success'>Brand Added Successfully!...</span>"
            );
            brand_name.val("");
          } else {
            alert(data);
          }
        },
      });
    }
    fetchBrand();
  });

  // fetch brand
  fetchBrand();
  function fetchBrand() {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: { getBrand: 1 },
      success: function (data) {
        var choose = "<option value=''>Choose Brand</option>";
        $("#select_brand").html(choose + data);
      },
    });
  }

  // add products
  $("#product_form").on("submit", function () {
    var date = $("#added_date");
    var product_name = $("#product_name");
    var cid = $("#select_cat");
    var bid = $("#select_brand");
    var price = $("#product_price");
    var qauntity = $("#product_qty");
    fetchBrand();
    fetch_category();
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: {
        product_name: product_name.val(),
        date: date.val(),
        cid: cid.val(),
        bid: bid.val(),
        price: price.val(),
        qauntity: qauntity.val(),
      },
      success: function (data) {
        if (data === "PRODUCT ADDED") {
          alert("Product Added Successfully!...");
          product_name.val(""),
            cid.val(""),
            bid.val(""),
            price.val(""),
            qauntity.val("");
        } else {
          alert("error");
        }
      },
    });
  });
});
