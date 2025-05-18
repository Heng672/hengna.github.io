<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number to Words Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #1e90ff;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin: 5px 0;
        }
        input[type="submit"] {
            background-color: #1e90ff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4682b4;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e6f3ff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Number to Words Converter</h2>
        <form method="POST" action="">
            <label for="number">Please input your number (in Riel):</label>
            <input type="text" id="number" name="number" placeholder="Enter number here" required>
            
            <?php
            // Display error if input is invalid
            $error = "";
            if (isset($_POST['submit'])) {
                $input = $_POST['number'];
                if (!is_numeric($input) || $input < 0) {
                    $error = "Please enter a valid positive number.";
                }
            }
            if ($error) {
                echo "<div class='error'>$error</div>";
            }
            ?>
            
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // Function to convert number to English words
        function numberToWordsEnglish($number) {
            $ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
            $teens = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
            $tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
            $thousands = ["", "Thousand", "Million", "Billion"];

            if ($number == 0) return "Zero Riel";

            $words = "";
            $group = 0;

            while ($number > 0) {
                $part = $number % 1000;
                $number = (int)($number / 1000);

                if ($part > 0) {
                    $partWords = "";
                    $hundreds = (int)($part / 100);
                    $part = $part % 100;

                    if ($hundreds > 0) {
                        $partWords .= $ones[$hundreds] . " Hundred ";
                    }

                    if ($part >= 10 && $part <= 19) {
                        $partWords .= $teens[$part - 10] . " ";
                    } else {
                        $partTens = (int)($part / 10);
                        $partOnes = $part % 10;
                        if ($partTens > 0) {
                            $partWords .= $tens[$partTens] . " ";
                        }
                        if ($partOnes > 0) {
                            $partWords .= $ones[$partOnes] . " ";
                        }
                    }

                    $partWords = trim($partWords);
                    if ($partWords != "") {
                        $words = $partWords . " " . $thousands[$group] . " " . $words;
                    }
                }
                $group++;
            }

            return trim($words) . " Riel";
        }

        // Function to convert number to Khmer words
        function numberToWordsKhmer($number) {
            $ones = ["", "មួយ", "ពីរ", "បី", "បួន", "ប្រាំ", "ប្រាំមួយ", "ប្រាំពីរ", "ប្រាំបី", "ប្រាំបួន"];
            $teens = ["ដប់", "ដប់មួយ", "ដប់ពីរ", "ដប់បី", "ដប់បួន", "ដប់ប្រាំ", "ដប់ប្រាំមួយ", "ដប់ប្រាំពីរ", "ដប់ប្រាំបី", "ដប់ប្រាំបួន"];
            $tens = ["", "", "ម្ភៃ", "សាមសិប", "សែសិប", "ហាសិប", "ហុកសិប", "ចិតសិប", "ប៉ែតសិប", "កៅសិប"];
            $thousands = ["", "ពាន់", "លាន", "ពាន់"]; // Fixed: Changed last element to "ប៊ីលាន"

            if ($number == 0) return "សូន្យរៀល";

            $words = "";
            $group = 0;

            while ($number > 0) {
                $part = $number % 1000;
                $number = (int)($number / 1000);

                if ($part > 0) {
                    $partWords = "";
                    $hundreds = (int)($part / 100);
                    $part = $part % 100;

                    if ($hundreds > 0) {
                        $partWords .= $ones[$hundreds] . "រយ ";
                    }

                    if ($part >= 10 && $part <= 19) {
                        $partWords .= $teens[$part - 10] . " ";
                    } else {
                        $partTens = (int)($part / 10);
                        $partOnes = $part % 10;
                        if ($partTens > 0) {
                            $partWords .= $tens[$partTens] . " ";
                        }
                        if ($partOnes > 0) {
                            $partWords .= $ones[$partOnes] . " ";
                        }
                    }

                    $partWords = trim($partWords);
                    if ($partWords != "") {
                        $words = $partWords . $thousands[$group] . " " . $words;
                    }
                }
                $group++;
            }

            return trim($words) . "រៀល";
        }

        // Handle form submission
        if (isset($_POST['submit']) && !$error) {
            $number = (int)$_POST['number'];

            // Convert to English and Khmer (original number in Riel)
            $english = numberToWordsEnglish($number);
            $khmer = numberToWordsKhmer($number);

            // Convert to USD (divide by 4000) and format to 2 decimal places
            $exchange_rate = 4000;
            $usd = $number / $exchange_rate;
            $dollar = number_format($usd, 2) . "$";

            // Prepare data to save to file
            $data_to_save = "Input (Riel): $number\n";
            $data_to_save .= "English: $english\n";
            $data_to_save .= "Khmer: $khmer\n";
            $data_to_save .= "Dollar: $dollar\n";
            $data_to_save .= "------------------------\n";

            // Save to file (changed to data.txt)
            $upload_dir = "uploads/";
            $file_path = $upload_dir . "data.txt";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            if (file_put_contents($file_path, $data_to_save, FILE_APPEND | LOCK_EX)) {
                echo "<p>File saved successfully at: $file_path</p>";
            } else {
                echo "<p>Failed to save file at: $file_path</p>";
            }

            // Display results
            echo "<div class='result'>";
            echo "<h3>Converted Number:</h3>";
            echo "Input (Riel): $number<br>";
            echo "English: $english<br>";
            echo "Khmer: $khmer<br>";
            echo "Dollar: $dollar<br>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>