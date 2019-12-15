import numpy as np
import random

clusters = []		# total amount for each cluster
clusterNum = []     # total number of data points in each cluster

centroids = []		# Centroids used in the current model, will be placed at random locations
                    # This value will be a double because it holds the average value of all data points in the cluster

data_cluster =[]	# Array containing the connection between data points and centroids
                    # [ [data point], centroid index ]
                    # [ [data point], centroid index ]
                    # ...

data_points = []	# List containing all the data points


# This is the first function used as it initializes the global variables used in other methods
# This function takes input from the PHP webpage and converts it to a HashMap consisting of 
# INPUT fileText (String)    - Text of the user uploaded file
# INPUT dim (Integer)        - dimension of data points in the file
# INPUT clusterAmount (Integer) - amount of clusters the user defined
def km_init(fileText, dim, num):
    dimension = dim
    clusterAmount = num
    
    max = float(fileText[0])
    min = float(fileText[0])

    # File Text is split into data points separated by array
    splitLine = fileText.split("\n")
    
    for y in splitLine:
        dataPointInt = []
        dataPointString = y.split(" ")
        for x in dataPointString:
            if(x != ''):
                val = float(x)
                if(max < x): max = val
                if(min > x): min = val
                # Adding a value to the data point
                dataPointInt.append(val)
    
        # Append data point to list of data points
        if(len(dataPointInt)!= 0):
            data_points.append(dataPointInt)

    # Generate centroids for the amount of clusters defined by the user
    for c in range(clusterAmount):
        # Array holding the centroid point
        c_data_point = []
        
        # Array holding the the total value of all the data points assigned to a centroid as [0,0,..] for each dimension
        cluster_total_data_point = []
        
        for i in range(dimension):
            # Adds randomized centroid points for each centroid
            c_data_point.append(random.randrange(min, max))
            
            # Initializes the array with 0 because the total data point values haven't been used and assigned to clusters
            cluster_total_data_point.append(0.0)
        
        # Initializes each amount of data points attached to a cluster to 0
        clusterNum.append(0)
        centroids.append(c_data_point)
        clusters.append(cluster_total_data_point)


    # Assign centroids to data points using a the data_cluster 2 dimensional array
    for p in data_points:
        
        # Outputs index of centroid this point is closest to and creates an array to hold this tuple
        c_index = compareCluster(p)
        cluster_assign = [p, c_index]
        
        # Calls a method that adds the data points value to the clusters array with an index based on the assigned centroid
        addPointCluster(p, c_index)

        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster.append(cluster_assign)

    print "This is the initialized data_cluster: "
    for a in data_cluster:
        print(a)
    print
    print "This is centroids array: ", centroids
    print
    KMeans(clusterAmount)


# This method carries out the algorithm by utilizing the updateDataPoints method
# Since the k-init method assigns the initial data points to the clusters, this method will start off with updating centroids
def KMeans(clusterAmount):
    ogCentroids =[]
    
    # Keep the original centroid values
    for a in centroids:
        copy = []
        for p in a:
            copy.append(p)
        ogCentroids.append(copy)

    # Since the k_init method initialized the data points, this must be done outside a loop
    updateCentroids(clusterAmount)

    index = 0
    carry_on = True
    # While the original centroids and the updated centroids are not the same, the algorithm will continue to find new clusters for the data points
    while(carry_on):
        check =checkOG(ogCentroids)
        ogCentroids = []
        if(check == False):
            # Update the data points with the new centroids
            updateDataPoints()
            # Keep the original centroid values
            for a in centroids:
                copy = []
                for p in a:
                    copy.append(p)
                ogCentroids.append(copy)

            # Call method to update the centroids
            updateCentroids(clusterAmount)
            index = index+1
        else:
            break

    print
    print
    print "The final index is" ,index
    print
    print
    print "This is the final data_cluster: "
    for a in data_cluster:
        print(a)
    print "These are the final centroid values: "
    for a in centroids:
        print(a)

# This method compares an array with the current centroids array
# INPUT og: Array to be compared with the centroids array
# OUTPUT: True if the arrays are the same, False if the arrays are different
def checkOG(og):
    index = 0
    for b in centroids:
        if(og[index] != b):
            return False
        index = index+1
    return True


# Eucilidian - this distance calculus is independent of dimensions.
# For example, a model with 4 dimensional points will have its distance computes as: d(a,b) = sqrt( (a1-b1)^2 + (a2-b2)^2 + (a3-b3)^2 + (a4-b4)^2 )
# INPUT p1, p2: Points to compare the Eucilidian distance between
# OUTPUT: Distance between the two points
def km_distance(p1, p2):
    total = 0
    
    # Allows selection for both data points as arrays
    index = 0
    for y in p2:
        total += np.square((p1[index]-p2[index]))
    return np.sqrt(total)

# This method compares the distance between a point and all of the Centroids in the centroids array
# INPUT p: Point to compare with all the centroids
# OUTPUT: Index of the centroid the point is closest to
def compareCluster(p):
    dist = km_distance(p, centroids[0])
    centroid = 0;
    index = 0;
    for x in centroids:
        val = km_distance(p, x)
        if(val < dist):
            dist = val
            centroid = index
        index = index + 1
    return centroid

# This method assigns a point to the designated cluster along with incrementing the amount of data points attached to the specific cluster
# INPUT p: Point to attached to cluster
# INPUT c: Index of the centroid value to be attached to
def addPointCluster(p, c):
    
    # Extracts the cluster's centroid points at this value
    clust_t_dp = clusters[c]
    
    # Increments the amount of data points attached to a cluster
    clusterNum[c] = clusterNum[c] + 1

    # Adds each data point's dimensional point to the cluster's corelating point EX. p = [2, 4] and c = [3, 5]  >> c = [5, 9]
    index = 0
    for dp, cl in zip(p, clust_t_dp):
        clust_t_dp[index] = cl + dp
        index = index+1

# This method updates the Data Points attached cluster based on which cluster is the closest
# By looping through all the centroids in the clusters, the data points compare the distance and choose the closest centroid to attach to
def updateDataPoints():
    # Assign centroids to data points using a the data_cluster 2 dimensional array
    index = 0
    
    for x in data_cluster:
        dp_cluster_combo = data_cluster[index]
        point = dp_cluster_combo[0]
        
        # Outputs index of centroid this point is closest to and creates an array to hold this tuple
        c_index = compareCluster(point)
        cluster_assign = [point, c_index]
        
        # Calls a method that adds the data points value to the clusters array with an index based on the assigned centroid
        addPointCluster(point, c_index)
        
        # Adds the data point as a key of the point and value of the  centroid's index in the array
        data_cluster[index] = cluster_assign
        index = index + 1


# This method computes the average of all the data points assigned and assigns this value to the centroid
# Since all the clusters have been assigned in the init or the k-means function, the average of the clusters must be computed for each centroid
# INPUT num: Cluster Amount
def updateCentroids(num):
    for i in range(num):
        currentCentroid = centroids[i]
        currentTotal = clusters[i]
        currentNum = clusterNum[i]
        index = 0
        for a, b in zip(currentCentroid, currentTotal):
            if(currentNum != 0):
                average = float((a + b)/currentNum)
            else:
                # The average value is 0 if there are no data points in a cluster
                average = 0
            currentCentroid[index] = average
            currentTotal[index] = 0
            index = index+1
        clusterNum[i] = 0

print "Hello World"
stri = "1586 1445 525 \n 606 1238 1988 \n 440 247 771 \n 668 105 1209 \n 368 1187 1802 \n 768 844 787 \n 43 82 463 \n 1741 1964 224 \n 365 97 1805 \n 1554 1410 1745 \n 223 799 1912 \n 1763 1617 1558 \n 141 1908 747 \n 420 1761 690 \n 1721 1557 1748 \n 1224 1266 7 \n 1013 1880 1204 \n 1743 1856 1193 \n 1620 1369 405 \n 129 65 1148 \n 1364 491 1213 \n 1659 195 1300 \n 736 761 1401 \n 1953 1137 250 \n 1519 292 495 \n 1240 976 1838 \n 44 904 662 \n 143 451 176 \n 602 605 313 \n 1611 488 260 \n 683 1090 1913 \n788 516 529 \n576 253 34 \n1528 1654 1163 \n780 779 1347 \n1267 1936 380 \n1371 342 1817 \n843 826 232 \n101 1793 1851 \n1812 518 90 \n1300 1197 294 \n216 530 1609 \n1571 13 1573 \n1162 210 1825 \n411 819 1202 \n1621 977 1397 \n1109 434 1595 \n496 1493 1196 \n389 1905 380 \n1059 1862 1925 \n644 904 85 \n1630 1980 1764 \n225 285 1383 \n621 95 1586 \n1666 142 1908 \n1740 1288 248 \n1333 1863 1055 \n185 1000 26 \n8 1015 1146 \n1413 1750 779 \n 64 1815 1155 \n1301 1286 1357 \n623 700 1907 \n451 533 1208 \n1606 274 58 \n1105 1366 1450 \n1181 1028 1257 \n1664 598 810 \n1142 403 1235 \n1767 973 975 \n603 429 1338 \n518 1458 114 \n500 732 1688 \n903 1316 59 \n1322 718 1884 \n239 1178 1897 \n925 914 1041 \n581 1416 715 \n200 910 1538 \n1034 354 1228 \n1771 1557 939 \n276 1242 635 \n405 439 1117 \n1052 1047 1315 \n1967 508 1725 \n1843 703 350 \n1999 1086 176 \n1572 965 573 \n1513 826 1773 \n1048 219 409 \n729 725 1580 \n1470 339 164 \n328 1951 915 \n609 62 1343 \n994 1481 187 \n562 310 1742 \n1226 1504 807 \n1358 1724 989 \n332 1041 1071 \n1131 686 829 \n942 1346 1308 \n1519 1872 1390 \n271 1980 1878 \n783 1948 733 \n328 534 1521 \n1309 1365 448 \n1969 1530 776 \n1832 830 1905 \n506 485 1942 \n591 1280 479 \n1041 1624 1132 \n1293 1114 1868 \n1330 1067 315 \n761 324 306 \n622 1807 256 \n1458 227 1790 \n1124 566 881 \n574 1345 825 \n1684 475 829 \n1034 492 1647 \n1880 415 1465 \n678 1924 462 \n625 151 605 \n946 546 300 \n908 329 125 \n409 1999 1070 \n129 864 539 \n188 620 1593 \n898 1498 801 \n1734 1065 392 \n764 1956 809 \n456 1275 1927 \n1167 1382 1300 \n791 1596 711 \n1976 692 407 \n1625 1403 1 \n1211 1014 111 \n1393 1906 1013 \n81 1302 475 \n159 1499 711 \n950 406 270 \n845 315 874 \n805 839 879 \n1312 1118 106 \n204 701 258 \n1869 46 1614 \n1825 1685 797 \n1159 692 40 \n1871 1245 1999 \n810 841 1911 \n219 708 351 \n1552 359 1468 \n729 1758 91 \n1896 74 1405 \n1137 717 790 \n1442 250 1762 \n1806 1416 1745 \n328 1382 440 \n756 887 1861 \n1238 379 1957 \n1628 288 1126 \n333 339 631 \n1727 1486 702 \n1988 1356 816 \n1735 449 130 \n1246 1240 400 \n515 1764 1070 \n385 1129 1472 \n929 1534 1476 \n95 1032 1752 \n821 1047 1538 \n185 709 1341 \n1176 1068 1869 \n267 1283 1102 \n1178 615 955 \n1007 296 360 \n63 116 423 \n1726 92 42 \n800 1963 203 \n631 263 515 \n1186 90 1250 \n759 332 520 \n1232 914 1006 \n976 915 182 \n1469 1807 825 \n1048 1218 1854 \n683 441 189 \n1410 510 558 \n1094 954 1879 \n452 1766 1590 \n1840 856 1863 \n521 760 159 \n961 1855 179 \n1492 352 1045 \n1189 1763 185 \n463 1527 353 \n1113 1075 1850 \n887 314 571 \n876 577 737 \n252 1105 1355 \n1109 1563 1108 \n393 579 443 \n256 1793 1998 \n1203 1678 1545 \n1517 648 1838 \n1305 1534 170 \n1991 278 129 \n455 1667 1243 \n1337 1930 351 \n1685 1420 1991 \n514 362 89 \n1961 805 53 \n1388 1761 1127 \n267 853 737 \n674 208 311 \n832 975 1268 \n1807 611 1325 \n926 606 1147 \n1971 522 765 \n201 434 909 \n1034 1154 665 \n810 23 741 \n1573 1194 790 \n767 1906 1126 \n816 199 1418 \n813 694 1501 \n1032 766 524 \n880 319 1903 \n1742 206 18 \n10 589 239 \n1141 1605 1144 \n719 882 17 \n304 877 219 \n1882 1114 386 \n760 1138 889 \n1243 1936 660 \n1189 935 1571 \n450 1007 751 \n273 275 1361 \n901 1193 763 \n1855 103 1649 \n538 368 1291 \n351 1153 1985 \n1846 175 192 \n527 213 972 \n1704 1688 1319 \n1740 9 1643 \n849 193 1863 \n1201 770 430 \n1215 974 289 \n1172 1488 1518 \n1177 1203 1346 \n949 600 1449 \n1383 1440 1204 \n255 1795 1800 \n1113 1299 1920 \n1866 1706 1115 \n1873 914 654 \n363 1119 1667 \n1805 1500 252 \n1322 136 823 \n1893 1679 1152 \n1438 1168 1855 \n738 692 1053 \n885 1550 1610 \n1437 378 1876 \n980 130 1718 \n1477 15 746 \n1309 423 1440 \n76 118 1648 \n183 1626 153 \n1972 1721 1181 \n555 969 951 \n1621 1590 1088 \n522 193 1168 \n1759 1993 1990 \n1297 1469 621 \n758 490 1026 \n1373 1613 143 \n144 1618 89 \n642 348 1064 \n1373 909 812 \n968 1484 1663 \n1086 34 1693 \n924 1366 377 \n885 656 1565 \n709 825 970 \n801 286 911 \n67 1236 800 \n1838 649 1554 \n1345 1477 855 \n1864 1848 349 \n949 1145 912 \n1035 46 562 \n356 1843 1447 \n1517 1469 1016 \n292 62 1612 \n1809 1417 1288 \n303 817 1399 \n285 886 1471 \n628 903 1797 \n1322 1315 608 \n1969 900 554 \n449 593 1215 \n1826 204 1216 \n665 582 430 \n1472 331 923 \n1685 1027 684 \n1553 610 1963 \n1137 445 1971 \n1403 1549 1920 \n47 559 876 \n1473 246 1364 \n1401 1039 1288 \n202 1688 1003 \n1081 1592 515 \n1893 1098 1393 \n1976 1674 962 \n945 1443 819 \n969 1304 974 \n277 307 707 \n781 49 615 \n835 999 1955 \n1673 1079 1774 \n1570 286 1933 \n1772 533 860 \n825 953 141 \n945 1908 98 \n880 1554 1259 \n1696 375 1181 \n1256 803 1556 \n719 1420 879 \n552 749 1801 \n1477 1780 932 \n1447 1688 865 \n1308 861 945 \n547 431 298 \n1918 1288 742 \n860 1677 1496 \n1000 310 649 \n1273 199 1663 \n1302 66 1935 \n847 813 1021 \n1955 1927 696 \n955 492 451 \n1072 1343 323 \n1590 698 836 \n737 1976 963 \n759 4 512 \n1708 636 1617 \n474 316 1195 \n248 1857 114 \n837 774 839 \n486 1409 1373 \n856 1889 829 \n825 346 207 \n1382 162 392 \n1020 1440 330 \n1122 1744 1413 \n1771 841 435 \n1430 1022 1275 \n1907 360 557 \n970 269 64 \n928 1224 579 \n1364 846 1671 \n460 1017 1094 \n239 1478 5 \n360 3 427 \n605 1611 1008 \n1429 1932 1893 \n1605 1028 1768 \n602 1927 451 \n802 462 1629 \n189 1198 1435 \n382 46 1166 \n727 194 1796 \n1058 248 513 \n967 711 509 \n1843 140 145 \n590 26 757 \n1989 999 234 \n517 1063 1046 \n772 539 1264 \n376 1579 1805 \n1295 1642 677 \n370 1411 428 \n24 1089 1714 \n518 99 615 \n243 908 199 \n1379 262 1148 \n1764 1953 1068 \n297 1577 1313 \n1619 1172 1629 \n893 423 1581 \n1160 543 586 \n542 217 1059 \n1174 1888 1761 \n1540 1468 634 \n1787 1325 1534 \n1674 951 500 \n1389 921 1945 \n1999 514 929 \n1777 1376 1127 \n1022 906 118 \n1468 560 781 \n20 834 1219 \n1498 1171 537 \n667 1967 1964 \n296 675 1068 \n1221 1860 1454 \n1124 834 825 \n408 1124 1412 \n828 1902 254 \n1109 1217 1276 \n1428 1205 1946 \n934 503 1947 \n1607 1591 1582 \n688 941 306 \n814 1195 1204 \n398 1340 1064 \n1465 1759 542 \n1078 1260 162 \n1160 1481 440 \n510 1565 1236 \n1958 452 1997 \n141 1118 1148 \n1350 754 44 \n1761 870 119 \n1263 1670 1272 \n432 1021 1194 \n1440 207 326 \n737 293 636 \n1858 552 1047 \n497 1319 792 \n757 1391 603 \n1471 1958 1508 \n656 1923 294 \n1993 1299 1354 \n648 126 452 \n989 1021 1626 \n350 951 1143 \n95 1328 580 \n862 1071 1607 \n781 1977 316 \n10 6 774 \n526 1415 1587 \n799 604 1983 \n853 635 1903 \n63 249 683 \n566 1777 1177 \n1582 8 1971 \n399 194 1554 \n799 94 120 \n1110 1203 776 \n606 1495 1441 \n1251 1010 1078 \n204 1074 184 \n1609 1315 1795 \n1024 1611 798 \n568 845 1576 \n"

di = 3
ca = 3
km_init(stri, di, ca)


"""
    total = ''
    for i in range(400):
    for p in range(3):
    val = int(random.randrange(0, 2000))
    str1 = str(val)
    total += str1
    total += ' '
    total += r'\n'
    print(total)
    """
