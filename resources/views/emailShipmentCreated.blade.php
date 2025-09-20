<p>Dear {{ json_decode($shipment->CONTACT_DETAILS)->senderName }}</p>
<p>Your shipment is created successfully!</p>
<p>ORDER NUMBER: {{ $shipment->ORDER_NUMBER }}</p>
<table border="1">
    <tr>
        <td>
            <strong>Sender</strong><br>
            <u>Name: </u>{{ json_decode($shipment->CONTACT_DETAILS)->senderName }}<br>
            <u>Street: </u>{{ json_decode($shipment->CONTACT_DETAILS)->senderStreetName }}<br>
            <u>Number: </u>{{ json_decode($shipment->CONTACT_DETAILS)->senderStreetNumber }}<br>
            <u>City: </u>
            <span>
                {{ $shipment->SENDER_CODE }} {{ $shipment->SENDER_CITY }} {{ $shipment->SENDER_PROVINCE }}<br>{{ $shipment->SENDER_COUNTRY }}
            </span><br>
            <u>Phone: </u>{{ json_decode($shipment->CONTACT_DETAILS)->senderPhone }}<br>
            <u>Email: </u>{{ json_decode($shipment->CONTACT_DETAILS)->senderEmail }}<br>
        </td>
        <td>
            <strong>Receiver</strong><br>
            <u>Name: </u>{{ json_decode($shipment->CONTACT_DETAILS)->receiverName }}<br>
            <u>Street: </u>{{ json_decode($shipment->CONTACT_DETAILS)->receiverStreetName }}<br>
            <u>Number: </u>{{ json_decode($shipment->CONTACT_DETAILS)->receiverStreetNumber }}<br>
            <u>City: </u>
            <span>
                {{ $shipment->SENDER_CODE }} {{ $shipment->SENDER_CITY }} {{ $shipment->SENDER_PROVINCE }}<br>{{ $shipment->SENDER_COUNTRY }}
            </span><br>
            <u>Phone: </u>{{ json_decode($shipment->CONTACT_DETAILS)->receiverPhone }}<br>
            <u>Email: </u>{{ json_decode($shipment->CONTACT_DETAILS)->receiverEmail }}<br>
        </td>
    </tr>
    <tr>
        <td>
            <u>COURIER: </u>{{ $shipment->COURIER }}<br>
            <u>PRICE: </u>$ {{ $shipment->PRICE }}<br>
            <u>weight: </u>{{ json_decode($shipment->DETAILS)->weight }}<br>
            <u>weight: </u>{{ json_decode($shipment->DETAILS)->length }}<br>
            <u>weight: </u>{{ json_decode($shipment->DETAILS)->width }}<br>
            <u>weight: </u>{{ json_decode($shipment->DETAILS)->height }}
        </td>
    </tr>
</table>