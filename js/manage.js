$(document).ready(function () {
  var DOMAIN =
    "http://localhost/PHP Programs (Laik)/PHP Projects/Inventory Management System/public_html";
  // ----------manage category------//
  function manageCategory(pn) {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: { manageCategory: 1, pageno: pn },
      success: function (data) {
        $("#get_category").html(data);
      },
    });
  }
  manageCategory(1);

  // pagination
  $("body").delegate(".page-link", "click", function () {
    var pn = $(this).attr("pn");
    manageCategory(pn);
  });

  //Fetch category
  fetch_category();
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

  //Fetch Brand
  fetch_brand();
  function fetch_brand() {
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

  // delete category
  $("body").delegate(".del_cat", "click", function () {
    var did = $(this).attr("did");
    if (confirm("Are you sure ? You want to delete..!")) {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: { deleteCategory: 1, id: did },
        success: function (data) {
          if (data == "DEPENDENT_CATEGORY") {
            alert("Sorry ! this Category is dependent on other sub categories");
          } else if (data == "CATEGORY_DELETED") {
            alert("Category Deleted Successfully..! happy");
            manageCategory(1);
          } else if (data == "DELETED") {
            alert("Deleted Successfully");
          } else {
            alert(data);
          }
        },
      });
    }
  });

  //Update Category
  $("body").delegate(".edit_cat", "click", function () {
    var eid = $(this).attr("eid");
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      dataType: "json",
      data: { updateCategory: 1, id: eid },
      success: function (data) {
        $("#cid").val(data["cid"]);
        $("#update_category").val(data["category_name"]);
        $("#parent_cat").val(data["parent_cat"]);
      },
    });
  });

  $("#update_category_form").on("submit", function () {
    if ($("#update_category").val() == "") {
      $("#update_category").addClass("border-danger");
      $("#cat_error").html(
        "<span class='text-danger'>Please Enter Category Name</span>"
      );
    } else {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          update_category: $("#update_category").val(),
          cid: $("#cid").val(),
          parent_cat: $("#parent_cat").val(),
        },
        success: function (data) {
          window.location.href = "";
        },
      });
    }
  });

  //----------Brands-----------------//

  function manageBrands(pn) {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: { manageBrands: 1, pageno: pn },
      success: function (data) {
        $("#get_brand").html(data);
      },
    });
  }
  manageBrands(1);

  // pagination
  $("body").delegate(".page-link", "click", function () {
    var pn = $(this).attr("pn");
    manageBrands(pn);
  });

  //delete brands
  $("body").delegate(".del_brand", "click", function () {
    var did = $(this).attr("did");
    if (confirm("Are you sure ? You want to delete..!")) {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: { deleteBrand: 1, id: did },
        success: function (data) {
          if (data === "DELETED") {
            alert("Brand is Deleted Successfully!");
            manageBrands(1);
          } else {
            alert(data);
          }
        },
      });
    }
  });

  // update brands
  $("body").delegate(".edit_brand", "click", function () {
    var eid = $(this).attr("eid");
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      dataType: "json",
      data: { updateBrand: 1, id: eid },
      success: function (data) {
        $("#bid").val(data["bid"]);
        $("#update_brand").val(data["brand_name"]);
      },
    });
  });
  $("#update_brand_form").on("submit", function () {
    if ($("#update_brand").val() == "") {
      $("#update_brand").addClass("border-danger");
      $("#brand_error").html(
        "<span class='text-danger'>Please Enter Brand Name</span>"
      );
    } else {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          bid: $("#bid").val(),
          update_brand: $("#update_brand").val(),
        },
        success: function (data) {
          alert(data);
          window.location.href = "";
        },
      });
    }
  });

  // -------------- Products -------------//
  function manageProducts(pn) {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: { manageProducts: 1, pageno: pn },
      success: function (data) {
        $("#get_product").html(data);
      },
    });
  }
  manageProducts(1);

  // pagination
  $("body").delegate(".page-link", "click", function () {
    var pn = $(this).attr("pn");
    manageProducts(pn);
  });

  // delete products
  $("body").delegate(".del_product", "click", function () {
    var pid = $(this).attr("did");
    if (confirm("Are you sure ? You want to delete..!")) {
      $.ajax({
        url: DOMAIN + "/includes/process.php",
        method: "POST",
        data: {
          deleteProduct: 1,
          id: pid,
        },
        success: function (data) {
          if (data === "DELETED") {
            alert("Data is been Deleted Successfully!");
            manageProducts(1);
          } else {
            alert("You Cannot delete this product");
          }
        },
      });
    }
  });

  //update product
  $("body").delegate(".edit_product", "click", function () {
    var eid = $(this).attr("eid");
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      dataType: "json",
      data: { updateProduct: 1, id: eid },
      success: function (data) {
        console.log(data);
        $("#pid").val(data["pid"]);
        $("#update_product").val(data["product_name"]);
        $("#select_cat").val(data["cid"]);
        $("#select_brand").val(data["bid"]);
        $("#product_price").val(data["product_price"]);
        $("#product_qty").val(data["product_stock"]);
      },
    });
  });
  $("#update_product_form").on("submit", function () {
    $.ajax({
      url: DOMAIN + "/includes/process.php",
      method: "POST",
      data: {
        added_date: $("#added_date").val(),
        pid: $("#pid").val(),
        update_product: $("#update_product").val(),
        select_cat: $("#select_cat").val(),
        select_brand: $("#select_brand").val(),
        product_price: $("#product_price").val(),
        product_qty: $("#product_qty").val(),
      },
      success: function (data) {
        if (data == "UPDATED") {
          alert("Product Updated Successfully..!");
          window.location.href = "";
        } else {
          alert(data);
        }
      },
    });
  });
});
