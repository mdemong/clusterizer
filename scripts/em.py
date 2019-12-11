import numpy as np

def expectation_maximization(k, pointList, distributions=[]):
    # Initialize parameters (mean, variance)

    if(distributions==[]):
        distributions = init_random_distributions()

    # Alternate between E and M step until change is negligable
    changed = True
    while(changed):
        changed = False

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribuion parameters
        expectation()

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on 
          # maximum likelihood estimators
        maximization()
        
    return []


def init_random_distributions():
    return


# TODO: define function signature
def expectation():
    return


# TODO: define function signature
def maximization():
    return