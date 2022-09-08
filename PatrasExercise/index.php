<!DOCTYPE html>
<html>

<body style="background-color: #2c53c5;">
    <div style="margin: auto; width: 50%;
  border: 3px solid black;
  padding: 10px; text-align: center; background-color:white; color:#5a5c69">
        <h1> Patras Sports News </h1>
    </div>
    <div style="margin: auto; width: 50%;
  padding: 10px; text-align: center; background-color:white; color:#5a5c69">
        <select id="filter_area" onchange="applyFilter(event)"></select>
    </div>

    <div style="margin: auto; width: 50%;
  padding: 10px; text-align: center; background-color:white; color:#5a5c69">
        <h2>Νέα Δημοσίευση</h2>
        <form id="new_post" onsubmit="event.preventDefault(); submitForm()">
            <table style="margin: auto ;">
                <tr>
                    <td>
                        <label for="post_title">Τίτλος</label>
                    </td>
                    <td colspan="2"><input type="text" name="post_title"></td>
                </tr>

                <tr>
                    <td><label for="author_name">Συντάκτης</label></td>
                    <td colspan="2"><input type="text" name="author_name"></td>
                </tr>
                <tr>
                    <td><label for="post_text">Κείμενο</label></td>
                    <td colspan="2"><textarea rows="5" name="post_text"></textarea></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h4>Κατηγορίες</h4>
                    </td>
                </tr>
                <tr id="categories_area">
                </tr>
                <tr>
                    <td colspan="3"><button type="submit">Δημιουργία Δημοσίευσης</button></td>
                </tr>
            </table>
        </form>
    </div>
    <div style=" padding: 10px;width: 50%; margin: auto; background-color:white; color:#5a5c69;" id="posts_area">

</body>
<script>
    var posts_area = document.getElementById('posts_area');
    var categories_area = document.getElementById('categories_area');
    var filter_area = document.getElementById('filter_area');

    //Handles all GET requests from the server
    async function getDataFromAPI(url) {
        try {
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.log(error);
        }
    }

    //Handles all POST requests to the server
    async function postDataToAPI(url, data) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            console.log(data);
            return response.json();
        } catch (error) {
            console.log(error);
        }
    }

    //Submits form
    function submitForm() {
        var categories = checkIfChecked();
        var inputs = document.querySelectorAll('input[type=text]');
        var textarea = document.getElementsByTagName('textarea');
        if (categories) {
            var data = []
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type != 'checkbox') {
                    data[inputs[i].name] = inputs[i].value;
                }
            }
            var post_text = textarea[0].value;
            var res = postDataToAPI('api/posts', {
                'post_text': post_text,
                'post_categories': categories,
                'post_title': data['post_title'],
                'author_name': data['author_name']
            });
            window.location.reload();
        }
        return;

    }

    //Checks if at least one category is checked, then adds them to an array
    function checkIfChecked() {

        var inputs = document.getElementsByTagName('input');
        var textarea = document.getElementsByTagName('textarea');
        var flag = false;
        var checkedCategories = [];

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked) {
                checkedCategories.push(inputs[i].value);
                flag = true;
            }
            if (inputs[i].type != 'checkbox' && inputs[i].value == "") {
                alert('Παρακαλώ συμπληρώστε όλα τα πεδία');
                return false;
            }
        }
        if (textarea[0].value == "") {
            alert('Παρακαλώ συμπληρώστε όλα τα πεδία');
            return false;
        }
        if (!flag) {
            alert('Παρακαλώ επιλέξτε τουλάχιστον μια κατηγορία');
            return false;
        }

        return checkedCategories;
    }

    //Gets all available categories
    function getAllCategories() {
        var categories = getDataFromAPI('api/categories').then(categories => {
            setFormCategories(categories);
            setFilterCategories(categories);
        });
        return;
    }

    //Sets categories for the filter
    function setFilterCategories(categories) {
        var htmlcat = '<option value="0">Παρακαλώ επιλέξτε την κατηγορία για φιλτράρισμα</option>';
        for (i = 0; i < categories['item_count']; i++) {
            htmlcat += '<option value="' + categories['body'][i]['category_id'] + '">' + categories['body'][i]['category_name'] + '</option>';
        }
        filter_area.innerHTML = htmlcat;
    }

    //Applies Filter
    function applyFilter(event) {
        var current_value = event.target.value;
        if (current_value == 0) {
            getPosts();
        } else {
            getPostsByCategory(current_value);
        }
    }

    //Gets Posts based on Categoty_Id
    function getPostsByCategory(cat_id) {
        var posts = getDataFromAPI('api/postsbycategory?category_id='+cat_id).then(posts => {
            render_posts(posts)
        });
    }

    //Sets categories for the form
    function setFormCategories(categories) {
        var htmlcat = "";
        for (i = 0; i < categories['item_count']; i++) {
            htmlcat += '<td><input type="checkbox" value="' + categories['body'][i]['category_id'] + '" name="category[' + categories['body'][i]['category_id'] + ']"><label for="category[' + categories['body'][i]['category_id'] + ']"> ' + categories['body'][i]['category_name'] + '</label></td>';
        }
        categories_area.innerHTML = htmlcat;
    }

    function render_posts(posts) {
        var html = "";
        if (posts != null) {
            for (var i = 0; i < posts['item_count']; i++) {
                html += '<table style="margin: auto; padding: 10px; text-align: center; border: 1px solid black; "></div><tr><td><h3>' +
                    posts['body'][i]['post_title'] + '</h3></td></tr><tr><td><a href="#" onclick="upvote_post(' + posts['body'][i]['post_id'] + ')">Καλό: </a><span id="upvotes[' + posts['body'][i]['post_id'] + ']">' +
                    posts['body'][i]['post_upvotes'] + '</span>  <a href="#" onclick="downvote_post(' + posts['body'][i]['post_id'] + ')">Κακό: </a><span id="downvotes[' + posts['body'][i]['post_id'] + ']">' +
                    posts['body'][i]['post_downvotes'] + ' </span></tr><tr><td colspan="2"><h4>' + posts['body'][i]['post_text'] + '</h4></td></tr><tr><td colspan="2" style="text-align:right;">Συντάκτης: ' +
                    posts['body'][i]['author_name'] + '</td></tr><tr><td style="text-align: right; font-style: italic;">Κατηγορίες: ' + posts['body'][i]['category_name'] + '</td></tr</table>';
            }
        } else {
            html = "Δεν βρέθηκαν δημοσιεύσεις"
        }
        posts_area.innerHTML = html;
        return;

    }

    //Gets all posts
    function getPosts() {
        var posts = getDataFromAPI('api/posts').then(posts => {
            render_posts(posts)
        });
    }

    //Handles upvotes
    function upvote_post(post_id) {
        var upvotes = document.getElementById('upvotes[' + post_id + ']');
        postDataToAPI('api/votepost', {
            'post_id': post_id,
            'vote_type': 'up'
        });
        upvotes.innerHTML = ++upvotes.innerText;
    }

    //Handles downvotes
    function downvote_post(post_id) {
        var downvotes = document.getElementById('downvotes[' + post_id + ']');
        postDataToAPI('api/votepost', {
            'post_id': post_id,
            'vote_type': 'down'
        });
        downvotes.innerHTML = ++downvotes.innerText;
    }

    window.onload = function() {
        getPosts();
        getAllCategories();
    }
</script>

</html>